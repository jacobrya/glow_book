<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

class Specialist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'salon_id',
        'bio',
        'experience_years',
        'rating',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'rating' => 'decimal:2',
        ];
    }

    // --- Relationships ---

    /**
     * Get the user associated with the specialist.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the salon where the specialist works.
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * The services that the specialist provides.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'specialist_service');
    }

    /**
     * Get the appointments for the specialist.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the reviews for the specialist.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // --- Business Logic ---

    /**
     * Recalculate and update the specialist's overall rating based on all reviews.
     */
    public function updateRating(): void
    {
        $this->rating = $this->reviews()->avg('rating') ?? 0;
        $this->save();
    }

    /**
     * FEATURE: Master of the Month.
     * Retrieves the specialist with the highest average rating and
     * most reviews within the current calendar month.
     */
    public static function getMasterOfTheMonth(): ?self
    {
        return self::whereHas('reviews', function ($query) {
            // Only consider specialists who have reviews in the current month
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        })
            ->withAvg(['reviews' => function ($query) {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }], 'rating')
            ->withCount(['reviews' => function ($query) {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }])
            ->orderByDesc('reviews_avg_rating')
            ->orderByDesc('reviews_count')
            ->first();
    }

    /**
     * Get top 3 specialists by overall rating for the homepage.
     */
    public static function topThree(): Collection
    {
        return self::orderByDesc('rating')
            ->take(3)
            ->get();
    }
}
