<?php

namespace Database\Seeders;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EpisodeSeeder extends Seeder
{
    public function run()
    {
        Series::chunk(50, function ($seriesChunk) {
            foreach ($seriesChunk as $series) {
                $this->createEpisodesForSeries($series);
            }
        });
    }

    private function createEpisodesForSeries(Series $series)
    {
        $episodes = [
            [
                'title' => 'episode 1',
                'description' => 'The series begins with our introduction to the main characters.',
                'duration' => 45,
                'season_number' => 1,
                'episode_number' => 1,
                'thumbnail' => 'images/thumbnails/episode_1.png',
                'video_asset' => 'videos/episode_1.mp4',
            ],
            [
                'title' => 'episode 2',
                'description' => 'Our characters embark on their first adventure.',
                'duration' => 42,
                'season_number' => 1,
                'episode_number' => 2,
                'thumbnail' => 'images/thumbnails/episode_2.png',
                'video_asset' => 'videos/episode_2.mp4',
            ],
            [
                'title' => 'episode 3',
                'description' => 'Tension builds as conflicts emerge.',
                'duration' => 44,
                'season_number' => 1,
                'episode_number' => 3,
                'thumbnail' => 'images/thumbnails/episode_3.png',
                'video_asset' => 'videos/episode_3.mp4',
            ],
            [
                'title' => 'episode 4',
                'description' => 'Secrets are revealed that change everything.',
                'duration' => 47,
                'season_number' => 1,
                'episode_number' => 4,
                'thumbnail' => 'images/thumbnails/episode_4.png',
                'video_asset' => 'videos/episode_4.mp4',
            ],
            [
                'title' => 'episode 5',
                'description' => 'Characters face their biggest challenges yet.',
                'duration' => 43,
                'season_number' => 1,
                'episode_number' => 5,
                'thumbnail' => 'images/thumbnails/episode_5.png',
                'video_asset' => 'videos/episode_5.mp4',
            ],
            [
                'title' => 'episode 6',
                'description' => 'The season concludes with shocking revelations.',
                'duration' => 50,
                'season_number' => 1,
                'episode_number' => 6,
                'thumbnail' => 'images/thumbnails/episode_6.png',
                'video_asset' => 'videos/episode_6.mp4',
            ],
            [
                'title' => 'episode 7',
                'description' => 'Season 2 opens with new challenges and opportunities.',
                'duration' => 45,
                'season_number' => 2,
                'episode_number' => 1,
                'thumbnail' => 'images/thumbnails/episode_7.png',
                'video_asset' => 'videos/episode_7.mp4',
            ],
            [
                'title' => 'episode 8',
                'description' => 'The plot thickens with new mysteries to solve.',
                'duration' => 46,
                'season_number' => 2,
                'episode_number' => 2,
                'thumbnail' => 'images/thumbnails/episode_8.png',
                'video_asset' => 'videos/episode_8.mp4',
            ],
            [
                'title' => 'episode 9',
                'description' => 'An unexpected turn of events changes the game.',
                'duration' => 48,
                'season_number' => 2,
                'episode_number' => 3,
                'thumbnail' => 'images/thumbnails/episode_9.png',
                'video_asset' => 'videos/episode_9.mp4',
            ],
            [
                'title' => 'episode 10',
                'description' => 'The ultimate confrontation between good and evil.',
                'duration' => 52,
                'season_number' => 2,
                'episode_number' => 4,
                'thumbnail' => 'images/thumbnails/episode_10.png',
                'video_asset' => 'videos/episode_10.mp4',
            ],
        ];

        $data = [];
        foreach ($episodes as $index => $episode) {
            $data[] = [
                'series_id'      => $series->id,
                'title'          => $episode['title'],
                'description'    => $episode['description'],
                'duration'       => $episode['duration'],
                'airing_time'    => Carbon::now()->subDays(30 - $index * 3),
                'thumbnail'      => $episode['thumbnail'],
                'video_asset'    => $episode['video_asset'],
                'season_number'  => $episode['season_number'],
                'episode_number' => $episode['episode_number'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        Episode::insert($data);
    }
}
