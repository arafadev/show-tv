<?php

namespace App\Http\Controllers\User;

use App\Models\Episode;
use App\Models\EpisodeLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EpisodeRepository;
use App\Http\Requests\User\Episode\EpisodeLikeRequest;

class EpisodeController extends Controller
{

    public function __construct(protected EpisodeRepository $episodeRepository){ }

    public function show(Episode $episode)
    {
        $episode = $this->episodeRepository->findWithSeries($episode->id);

        $user = auth()->user();
        $like_status = $this->episodeRepository->getUserLikeStatus($user, $episode);
        $related_episodes = $this->episodeRepository->getRelatedEpisodes($episode, 6);

        return view('episodes.show', [
            'episode'          => $episode,
            'has_liked'         => $like_status['has_liked'],
            'has_disliked'      => $like_status['has_disliked'],
            'related_episodes'  => $related_episodes,
        ]);
    }


    public function toggleLike(EpisodeLikeRequest $request, Episode $episode)
    {
        $user = Auth::user();
        $isLike = $request->boolean('is_like');

        $result = $this->episodeRepository->toggleUserLike($user, $episode, $isLike);

        if ($request->ajax()) {
            return response()->json(array_merge(['success' => true], $result));
        }

        return back()->with('success', ucfirst($result['action']) . ' episode');
    }
}
