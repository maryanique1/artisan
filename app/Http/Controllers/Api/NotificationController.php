<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /** GET /api/notifications — liste paginée (non lues en premier) */
    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->orderByRaw('read_at IS NOT NULL')
            ->orderByDesc('created_at')
            ->paginate(20);

        $items = $notifications->map(fn ($n) => $this->format($n));

        return response()->json([
            'data'        => $items,
            'unread'      => $request->user()->unreadNotifications()->count(),
            'total'       => $notifications->total(),
            'has_more'    => $notifications->hasMorePages(),
        ]);
    }

    /** GET /api/notifications/unread-count — badge Flutter */
    public function unreadCount(Request $request): JsonResponse
    {
        return response()->json([
            'count' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    /** PATCH /api/notifications/{id}/read — marquer une comme lue */
    public function markRead(Request $request, string $id): JsonResponse
    {
        $notification = $request->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['message' => 'Notification marquée comme lue.']);
    }

    /** PATCH /api/notifications/read-all — tout marquer comme lu */
    public function markAllRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['message' => 'Toutes les notifications sont marquées comme lues.']);
    }

    /** DELETE /api/notifications/{id} — supprimer une notification */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $request->user()->notifications()->findOrFail($id)->delete();

        return response()->json(['message' => 'Notification supprimée.']);
    }

    /** DELETE /api/notifications — vider toutes */
    public function destroyAll(Request $request): JsonResponse
    {
        $request->user()->notifications()->delete();

        return response()->json(['message' => 'Notifications supprimées.']);
    }

    private function format($n): array
    {
        $data = is_array($n->data) ? $n->data : json_decode($n->data, true);

        return [
            'id'         => $n->id,
            'type'       => $n->type,
            'title'      => $data['title'] ?? null,
            'body'       => $data['body'] ?? null,
            'data'       => $data['extra'] ?? [],
            'read'       => !is_null($n->read_at),
            'created_at' => $n->created_at->toIso8601String(),
        ];
    }
}
