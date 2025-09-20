<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'airing_time',
        'poster_image',
    ];

    protected $casts = [
        'airing_time' => 'datetime',
    ];

    // Relationships
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_series_follows');
    }

    public function getPosterImageUrlAttribute()
    {
        return $this->poster_image ? asset('storage/' . $this->poster_image) : asset('images/default-poster.jpg');
    }

    public function scopeSearch(Builder $query, $search)
    {
        return $query->whereAny(['title', 'description'], 'like', "%{$search}%");
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy('airing_time', 'desc');
    }

    public function scopeRandom(Builder $query, $limit = 5)
    {
        return $query->inRandomOrder()->limit($limit);
    }

    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getEpisodesCountAttribute()
    {
        return $this->episodes()->count();
    }
}