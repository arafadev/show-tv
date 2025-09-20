<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function followedSeries()
    {
        return $this->belongsToMany(Series::class, 'user_series_follows');
    }

    public function episodeLikes()
    {
        return $this->hasMany(EpisodeLike::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-avatar.png');
    }

    public function isFollowingSeries($seriesId)
    {
        return $this->followedSeries()->where('series_id', $seriesId)->exists();
    }

    public function hasLikedEpisode($episodeId)
    {
        return $this->episodeLikes()->where('episode_id', $episodeId)->where('is_like', true)->exists();
    }

    public function hasDislikedEpisode($episodeId)
    {
        return $this->episodeLikes()->where('episode_id', $episodeId)->where('is_like', false)->exists();
    }
}
