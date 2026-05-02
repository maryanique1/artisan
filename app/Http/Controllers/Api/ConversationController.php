<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Services\FirebasePushService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            'artisan_id' => ['required', 'exists:users,id,role,artisan'],
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

        $recipientId = $conversation->client_id === $user->id
            ? $conversation->artisan_id
            : $conversation->client_id;

        $body = $message->type === 'text'
            ? Str::limit($message->content, 80)
            : '📎 Pièce jointe';

        // Push FCM (app en arrière-plan / écran verrouillé)
        app(FirebasePushService::class)->sendToUser(
            userId: $recipientId,
            title: $user->first_name . ' ' . $user->last_name,
            body: $body,
            data: ['conversation_id' => (string) $conversation->id, 'type' => 'new_message'],
        );

        // Persister la notification en base (visible dans GET /api/notifications)
        DB::table('notifications')->insert([
            'id'              => Str::uuid()->toString(),
            'type'            => 'new_message',
            'notifiable_type' => 'App\\Models\\User',
            'notifiable_id'   => $recipientId,
            'data'            => json_encode([
                'title' => $user->first_name . ' ' . $user->last_name,
                'body'  => $body,
                'extra' => ['conversation_id' => $conversation->id, 'message_id' => $message->id],
            ]),
            'read_at'    => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => $message], 201);
    }

    /**
     * Nouveaux messages depuis un ID donné (polling Flutter)
     * GET /api/conversations/{conversation}/messages?after={last_message_id}
     */
    public function newMessages(Conversation $conversation, Request $request): JsonResponse
    {
        $user = $request->user();

        if ($conversation->client_id !== $user->id && $conversation->artisan_id !== $user->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $after = $request->integer('after', 0);

        // Vérification légère : existe-t-il un message plus récent ? (1 seule colonne, pas de JOIN)
        $hasNew = $conversation->messages()
            ->where('id', '>', $after)
            ->exists();

        if (!$hasNew) {
            return response()->json(['messages' => []]);
        }

        // Seulement si nécessaire : requête complète avec sender
        $messages = $conversation->messages()
            ->with('sender:id,first_name,last_name,avatar')
            ->where('id', '>', $after)
            ->oldest()
            ->get();

        // Marquer les nouveaux messages reçus comme lus
        $conversation->messages()
            ->where('id', '>', $after)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }
}
