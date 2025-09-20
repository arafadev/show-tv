@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h2 class="mb-4">Latest Episodes</h2>
        
        @if($latest_episodes->count() > 0)
            <div class="row">
                @foreach($latest_episodes as $episode)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card episode-card h-100">
                            <img src="{{ $episode->thumbnailUrl }}" class="card-img-top thumbnail" alt="{{ $episode->title }}">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ Str::limit($episode->title, 50) }}</h6>
                                <p class="card-text text-muted small mb-2">{{ $episode->series->title }}</p>
                                <p class="card-text small text-muted">{{ Str::limit($episode->description, 100) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-primary">{{ $episode->durationFormatted }}</span>
                                        <small class="text-muted">{{ $episode->airing_time->format('M d, Y') }}</small>
                                    </div>
                                    <a href="{{ route('episodes.show', $episode) }}" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-play"></i> Watch Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <h4>no episodes available</h4>
                <p class="text-muted">check back later for new content!</p>
            </div>
        @endif
    </div>
</div>
@endsection