<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\EpisodeLike;
use App\Models\User;
use App\Repositories\Interfaces\EpisodeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EpisodeRepository
{
    public function findWithSeries(int $id)
    {
        return Episode::with('series')->findOrFail($id);
    }

    public function getRelatedEpisodes(Episode $episode, int $limit = 6)
    {
        return Episode::where('series_id', $episode->series_id)
            ->where('id', '!=', $episode->id)
            ->orderBy('season_number', 'asc')
            ->orderBy('episode_number', 'asc')
            ->limit($limit)
            ->get();
    }

    public function toggleUserLike(User $user, Episode $episode, bool $isLike)
    {
        $existingLike = EpisodeLike::where([
            ['user_id', $user->id],
            ['episode_id', $episode->id],
        ])->first();

        if ($existingLike) {
            if ($existingLike->is_like == $isLike) {
                $existingLike->delete();
                $action = 'removed';
            } else {
                $existingLike->update(['is_like' => $isLike]);
                $action = $isLike ? 'liked' : 'disliked';
            }
        } else {
            EpisodeLike::create([
                'user_id'   => $user->id,
                'episode_id' => $episode->id,
                'is_like'   => $isLike,
            ]);
            $action = $isLike ? 'liked' : 'disliked';
        }

        return [
            'action'        => $action,
            'likesCount'    => $episode->likes()->where('is_like', true)->count(),
            'dislikesCount' => $episode->likes()->where('is_like', false)->count(),
            'hasLiked'      => $this->hasUserLikedEpisode($user, $episode->id),
            'hasDisliked'   => $this->hasUserDislikedEpisode($user, $episode->id),
        ];
    }

    public function getUserLikeStatus(User $user, Episode $episode)
    {
        return [
            'has_liked'    => $this->hasUserLikedEpisode($user, $episode->id),
            'has_disliked' => $this->hasUserDislikedEpisode($user, $episode->id),
        ];
    }

    private function hasUserLikedEpisode(User $user, int $episodeId)
    {
        return EpisodeLike::where([
            ['user_id', $user->id],
            ['episode_id', $episodeId],
            ['is_like', true],
        ])->exists();
    }

    private function hasUserDislikedEpisode(User $user, int $episodeId)
    {
        return EpisodeLike::where([
            ['user_id', $user->id],
            ['episode_id', $episodeId],
            ['is_like', false],
        ])->exists();
    }
}
