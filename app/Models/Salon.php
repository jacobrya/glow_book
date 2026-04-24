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
        'name', 'description', 'address', 'city', 'phone', 'image', 'owner_id',
    ];

    public static array $cities = [
        'Almaty', 'Astana', 'Shymkent', 'Karaganda', 'Aktobe',
        'Taraz', 'Pavlodar', 'Ust-Kamenogorsk', 'Semey', 'Atyrau',
        'Kostanay', 'Aktau', 'Oral', 'Kyzylorda', 'Petropavl',
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

   
    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('name', 'like', "%{$term}%");
        }
        
        return $query;
    }

   
    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->whereHas('services', function ($q) use ($category) {
                $q->where('category', $category);
            });
        }
        
        return $query;
    }

    
    public function scopeByCity($query, $city)
    {
        if ($city) {
            return $query->where('city', $city);
        }

        return $query;
    }

    public function scopeBestRated($query)
    {
        return $query->withAvg('specialists', 'rating')
                     ->orderBy('specialists_avg_rating', 'desc');
    }
}
