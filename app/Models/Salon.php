<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Salon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'address', 'phone', 'image', 'owner_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function specialists(): HasMany
    {
        return $this->hasMany(Specialist::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function averageRating(): float
    {
        $avg = $this->specialists()->avg('rating');
        return $avg ? round($avg, 1) : 0;
    }

    // Поиск по названию
    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('name', 'like', "%{$term}%");
        }
        
        return $query;
    }

    // Фильтр по категории
    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->whereHas('services', function ($q) use ($category) {
                $q->where('category', $category);
            });
        }
        
        return $query;
    }

    // Сортировка по рейтингу
    public function scopeBestRated($query)
    {
        return $query->withAvg('specialists', 'rating')
                     ->orderBy('specialists_avg_rating', 'desc');
    }
}
