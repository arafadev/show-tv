<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Series;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeriesFollowSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $series = Series::all();

        foreach ($users as $user) {
            // Each user follows 2-5 random series
            $followCount = rand(2, 5);
            $seriesToFollow = $series->random($followCount);
            
            foreach ($seriesToFollow as $show) {
                $user->followedSeries()->attach($show->id);
            }
        }
    }
}