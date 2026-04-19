<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArtisanProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'metier',
        'ville',
        'quartier',
        'portfolio',
        'proof_document',
        'proof_type',
        'validation_status',
        'rejection_reason',
        'validated_at',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'portfolio' => 'array',
            'is_available' => 'boolean',
            'rating_avg' => 'decimal:2',
            'validated_at' => 'datetime',
        ];
    }

    public function isApproved(): bool
    {
        return $this->validation_status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->validation_status === 'pending';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function totalLikesReceived(): int
    {
        return $this->publications()->sum('likes_count');
    }

    public function updateRating(): void
    {
        $this->rating_avg = $this->reviews()->avg('rating') ?? 0;
        $this->rating_count = $this->reviews()->count();
        $this->save();
    }
}
