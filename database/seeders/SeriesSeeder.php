<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    public function run()
    {
        $series = [
            [
                'title' => 'Serie 1',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subMonths(3),
                'poster_image' => 'images/posters/serie_1.png',
            ],
            [
                'title' => 'Serie 2',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subMonths(2),
                'poster_image' => 'images/posters/serie_2.png',
            ],
            [
                'title' => 'Serie 3',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subMonth(),
                'poster_image' => 'images/posters/serie_3.png',
            ],
            [
                'title' => 'Serie 4',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subWeeks(3),
                'poster_image' => 'images/posters/serie_4.png',
            ],
            [
                'title' => 'Serie 5',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subWeeks(2),
                'poster_image' => 'images/posters/serie_5.png',
            ],
            [
                'title' => 'Serie 6',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subWeek(),
                'poster_image' => 'images/posters/serie_6.png',
            ],
            [
                'title' => 'Serie 7',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subDays(5),
                'poster_image' => 'images/posters/serie_7.png',
            ],
            [
                'title' => 'Serie 8',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subDays(3),
                'poster_image' => 'images/posters/serie_8.png',
            ],
            [
                'title' => 'Serie 9',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subDays(3),
                'poster_image' => 'images/posters/serie_8.png',
            ],
            [
                'title' => 'Serie 10',
                'description' => 'lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, voluptate.',
                'airing_time' => Carbon::now()->subDays(3),
                'poster_image' => 'images/posters/serie_10.png',
            ],
        ];

        Series::insert($series);
    }
}
