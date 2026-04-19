<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'comment_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    protected static function booted(): void
    {
        static::created(fn (CommentLike $l) => $l->comment()->increment('likes_count'));
        static::deleted(fn (CommentLike $l) => $l->comment()->decrement('likes_count'));
    }
}
