<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\Series;
use App\Repositories\Interfaces\HomeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class HomeRepository
{
    public function getLatestEpisodes(int $limit = 12)
    {
        return Episode::with('series')->latest('airing_time')->limit($limit)->get();
    }

    public function searchContent(string $query)
    {
        $series = Series::whereAny(['title', 'description'], 'LIKE', "%{$query}%")
            ->with('episodes')
            ->get();

        $episodes = Episode::whereAny(['title', 'description'], 'LIKE', "%{$query}%")
            ->orWhereHas('series', function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%");
            })
            ->with('series')
            ->get();

        return [
            'series' => $series,
            'episodes' => $episodes
        ];
    }
}
