<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Episode;
use App\Models\EpisodeLike;
use Illuminate\Database\Seeder;

class EpisodeLikeSeeder extends Seeder
{
    public function run()
    {
        $users = User::cursor(); 
        $episodes = Episode::all();

        foreach ($users as $user) {
            $likeCount = rand(5, 15);
            $episodesToRate = $episodes->random($likeCount);

            $data = [];
            foreach ($episodesToRate as $episode) {
                $data[] = [
                    'user_id'    => $user->id,
                    'episode_id' => $episode->id,
                    'is_like'    => (bool) rand(0, 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            EpisodeLike::insert($data);
        }
    }
}

