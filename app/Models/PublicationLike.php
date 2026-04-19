<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicationLike extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'publication_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class);
    }

    protected static function booted(): void
    {
        static::created(fn (PublicationLike $l) => $l->publication()->increment('likes_count'));
        static::deleted(fn (PublicationLike $l) => $l->publication()->decrement('likes_count'));
    }
}
