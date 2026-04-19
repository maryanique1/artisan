<?php

namespace App\Http\Controllers\Api;

use App\Events\NewMessageSent;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Liste des conversations (client ou artisan)
     * GET /api/conversations
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $conversations = Conversation::where('client_id', $user->id)
            ->orWhere('artisan_id', $user->id)
            ->with([
                'client:id,first_name,last_name,avatar',
                'artisan:id,first_name,last_name,avatar',
                'latestMessage',
            ])
            ->withCount(['messages as unread_count' => function ($q) use ($user) {
                $q->where('sender_id', '!=', $user->id)->where('is_read', false);
            }])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return response()->json($conversations);
    }

    public function show(Conversation $conversation, Request $request): JsonResponse
    {
        $user = $request->user();

        if ($conversation->client_id !== $user->id && $conversation->artisan_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        // Marquer comme lus
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()
            ->with('sender:id,first_name,last_name,avatar')
            ->oldest()
            ->paginate(50);

        return response()->json([
            'conversation' => $conversation->load([
                'client:id,first_name,last_name,avatar',
                'artisan:id,first_name,last_name,avatar',
            ]),
            'messages' => $messages,
        ]);
    }

    /**
     * Démarrer ou récupérer une conversation avec un artisan
     * POST /api/conversations
     */
    public function startOrGet(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'artisan_id' => ['required', 'exists:users,id'],
        ]);

        $user = $request->user();

        $conversation = Conversation::firstOrCreate([
            'client_id' => $user->id,
            'artisan_id' => $validated['artisan_id'],
        ]);

        $conversation->load([
            'client:id,first_name,last_name,avatar',
            'artisan:id,first_name,last_name,avatar',
        ]);

        return response()->json(['conversation' => $conversation]);
    }

    /**
     * Envoyer un message
     * POST /api/conversations/{conversation}/messages
     */
    public function sendMessage(Conversation $conversation, Request $request): JsonResponse
    {
        $user = $request->user();

        if ($conversation->client_id !== $user->id && $conversation->artisan_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'content' => ['required_without:file', 'nullable', 'string'],
            'type' => ['sometimes', 'in:text,image,video,file'],
            'file' => ['nullable', 'file', 'max:20480'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('messages', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'content' => $validated['content'] ?? null,
            'type' => $validated['type'] ?? 'text',
            'file_path' => $filePath,
        ]);

        $conversation->update(['last_message_at' => now()]);

        $message->load('sender:id,first_name,last_name,avatar');

        // Broadcast temps réel dans la conversation
        broadcast(new NewMessageSent($message))->toOthers();

        // Notif push au destinataire
        $recipientId = $conversation->client_id === $user->id
            ? $conversation->artisan_id
            : $conversation->client_id;

        broadcast(new NewNotification(
            userId: $recipientId,
            type: 'new_message',
            title: $user->name,
            body: $message->type === 'text' ? \Illuminate\Support\Str::limit($message->content, 80) : '📎 Pièce jointe',
            data: ['conversation_id' => $conversation->id, 'message_id' => $message->id],
        ));

        return response()->json(['message' => $message], 201);
    }
}
