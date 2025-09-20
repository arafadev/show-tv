<?php

namespace App\Http\Controllers\User;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SeriesRepository;

class SeriesController extends Controller
{

    public function __construct(protected SeriesRepository $seriesRepository){}

    public function show(Series $series)
    {
        $series = $this->seriesRepository->findWithEpisodes($series->id);
        $is_following = $this->seriesRepository->isUserFollowing(auth()->user(), $series->id);

        return view('series.show', get_defined_vars());
    }

    public function toggleFollow(Request $request, Series $series)
    {
        $result = $this->seriesRepository->toggleUserFollow(auth()->user(),  $series);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'isFollowing' => $result['is_follow'],
                'message' => $result['message'],
                'followers_count' => $result['followers_count']
            ]);
        }

        return back()->with('success', $result['message']);
    }
}
