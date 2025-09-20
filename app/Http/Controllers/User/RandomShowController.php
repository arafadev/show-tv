<?php

namespace App\Http\Controllers\User;

use App\Models\Series;
use App\Models\Episode;
use App\Models\EpisodeLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RandomShowController extends Controller
{
    public function randomShows()
    {
        $randomShows = Cache::remember('random_shows', 600, function () {
            return Series::inRandomOrder()->limit(5)->get();
        });

        return response()->json($randomShows);
    }
}
