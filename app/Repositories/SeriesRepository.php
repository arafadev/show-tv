<?php
// app/Repositories/SeriesRepository.php

namespace App\Repositories;

use App\Models\Series;
use App\Models\User;
use App\Repositories\Interfaces\SeriesRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SeriesRepository
{
    public function findWithEpisodes(int $id)
    {
        return Series::with(['episodes' => function ($query) {
            $query->orderBy('season_number', 'asc')
                  ->orderBy('episode_number', 'asc');
        }])->findOrFail($id);
    }

    public function getRandomSeries(int $limit = 5)
    {
        return Series::select(['id', 'title'])
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function toggleUserFollow(User $user, Series $series)
    {
        if ($this->isUserFollowing($user, $series->id)) {
            $user->followedSeries()->detach($series->id);
            $is_follow = false;
            $message = 'Unfollowed series';
        } else {
            $user->followedSeries()->attach($series->id);
            $is_follow = true;
            $message = 'Following series';
        }

        return [
            'is_follow' => $is_follow,
            'message' => $message,
            'followers_count' => $series->followers()->count()
        ];
    }

    public function isUserFollowing(User $user, int $seriesId)
    {
        return $user->followedSeries()->where('series_id', $seriesId)->exists();
    }
}