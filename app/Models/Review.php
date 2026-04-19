<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'artisan_profile_id', 'rating', 'comment'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function artisanProfile(): BelongsTo
    {
        return $this->belongsTo(ArtisanProfile::class);
    }

    protected static function booted(): void
    {
        static::saved(fn (Review $r) => $r->artisanProfile?->updateRating());
        static::deleted(fn (Review $r) => $r->artisanProfile?->updateRating());
    }
}
