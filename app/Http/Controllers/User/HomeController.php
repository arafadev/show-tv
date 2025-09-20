<?php

namespace App\Http\Controllers\User;

use App\Models\Series;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $latest_episodes = Episode::with('series')
            ->latest()
            ->limit(12)
            ->get();

        return view('home', get_defined_vars());
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return redirect('/');
        }

        // Search in both series and episodes
        $series = Series::search($query)->with('episodes')->get();
        $episodes = Episode::search($query)->with('series')->get();

        return view('search-results', get_defined_vars());
    }
}