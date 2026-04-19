<?php

namespace App\Http\Controllers\Api;

use App\Events\CommentAdded;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Publication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Commentaires d'une publication (top-level + replies)
     * GET /api/publications/{publication}/comments
     */
    public function index(Publication $publication, Request $request): JsonResponse
    {
        $userId = $request->user()?->id;

        $comments = $publication->comments()
            ->whereNull('parent_id')
            ->with([
                'user:id,first_name,last_name,avatar',
                'replies.user:id,first_name,last_name,avatar',
            ])
            ->latest()
            ->paginate(20);

        if ($userId) {
            $allCommentIds = [];
            $comments->getCollection()->each(function ($c) use (&$allCommentIds) {
                $allCommentIds[] = $c->id;
                foreach ($c->replies as $r) $allCommentIds[] = $r->id;
            });

            $likedIds = CommentLike::where('user_id', $userId)
                ->whereIn('comment_id', $allCommentIds)
                ->pluck('comment_id')
                ->toArray();

            $comments->getCollection()->each(function ($c) use ($likedIds) {
                $c->liked_by_me = in_array($c->id, $likedIds);
                foreach ($c->replies as $r) $r->liked_by_me = in_array($r->id, $likedIds);
            });
        }

        return response()->json($comments);
    }

    /**
     * Ajouter un commentaire ou une réponse
     * POST /api/publications/{publication}/comments
     */
    public function store(Publication $publication, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        if (!empty($validated['parent_id'])) {
            $parent = Comment::find($validated['parent_id']);
            if ($parent->publication_id !== $publication->id) {
                return response()->json(['message' => 'Commentaire parent invalide.'], 422);
            }
        }

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'publication_id' => $publication->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);

        $comment->load('user:id,first_name,last_name,avatar');

        broadcast(new CommentAdded($comment))->toOthers();

        // Si c'est une réponse, notifier l'auteur du commentaire parent
        if ($comment->parent_id && $parent = Comment::find($comment->parent_id)) {
            if ($parent->user_id !== $request->user()->id) {
                broadcast(new NewNotification(
                    userId: $parent->user_id,
                    type: 'comment_reply',
                    title: $request->user()->name . ' a répondu à votre commentaire',
                    body: \Illuminate\Support\Str::limit($comment->content, 80),
                    data: ['publication_id' => $publication->id, 'comment_id' => $comment->id],
                ));
            }
        }

        return response()->json([
            'message' => 'Commentaire ajouté.',
            'comment' => $comment,
        ], 201);
    }

    public function destroy(Comment $comment, Request $request): JsonResponse
    {
        if ($comment->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé.']);
    }

    /**
     * Toggle like sur un commentaire
     * POST /api/comments/{comment}/like
     */
    public function toggleLike(Comment $comment, Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $existing = CommentLike::where('user_id', $userId)
            ->where('comment_id', $comment->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            CommentLike::create([
                'user_id' => $userId,
                'comment_id' => $comment->id,
            ]);
            $liked = true;

            // Notifier l'auteur du commentaire
            if ($comment->user_id !== $userId) {
                broadcast(new NewNotification(
                    userId: $comment->user_id,
                    type: 'comment_liked',
                    title: $request->user()->name . ' a aimé votre commentaire',
                    data: ['comment_id' => $comment->id, 'publication_id' => $comment->publication_id],
                ));
            }
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $comment->fresh()->likes_count,
        ]);
    }
}
