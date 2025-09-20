<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_id',
        'title',
        'description',
        'duration',
        'airing_time',
        'thumbnail',
        'video_asset',
        'episode_number',
        'season_number',
    ];

    protected $casts = [
        'airing_time' => 'datetime',
    ];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function likes()
    {
        return $this->hasMany(EpisodeLike::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-thumbnail.jpg');
    }

    public function getVideoUrlAttribute()
    {
        return asset('storage/' . $this->video_asset);
    }

    public function getDurationFormattedAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $minutes);
        }

        return sprintf('%dm', $minutes);
    }

    public function scopeSearch(Builder $query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->whereAny(['title', 'description'], 'like', "%{$search}%")
                ->orWhereHas('series', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
        });
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy('airing_time', 'desc');
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->where('is_like', true)->count();
    }

    public function getDislikesCountAttribute()
    {
        return $this->likes()->where('is_like', false)->count();
    }
}
