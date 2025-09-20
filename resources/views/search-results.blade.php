@extends('layouts.app')

@section('content')
<div class="search-results">
    <h2 class="mb-4">Search Results for "{{ $query }}"</h2>
    
    @if($series->count() > 0)
        <div class="mb-5">
            <h4 class="mb-3">TV Series ({{ $series->count() }})</h4>
            <div class="row">
                @foreach($series as $show)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card series-card h-100">
                            <img src="{{ $show->posterImageUrl }}" class="card-img-top" alt="{{ $show->title }}" style="height: 300px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $show->title }}</h6>
                                <p class="card-text small text-muted flex-grow-1">{{ Str::limit($show->description, 100) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted">{{ $show->episodes->count() }} episodes</small>
                                        <small class="text-muted">{{ $show->followersCount }} followers</small>
                                    </div>
                                    <a href="{{ route('series.show', $show) }}" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-tv"></i> View Series
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    @if($episodes->count() > 0)
        <div class="mb-5">
            <h4 class="mb-3">Episodes ({{ $episodes->count() }})</h4>
            <div class="row">
                @foreach($episodes as $episode)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card episode-card h-100">
                            <img src="{{ $episode->thumbnailUrl }}" class="card-img-top thumbnail" alt="{{ $episode->title }}">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ Str::limit($episode->title, 50) }}</h6>
                                <p class="card-text text-muted small mb-2">{{ $episode->series->title }}</p>
                                <p class="card-text small text-muted flex-grow-1">{{ Str::limit($episode->description, 100) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-primary">S{{ $episode->season_number }}E{{ $episode->episode_number }}</span>
                                        <span class="badge bg-secondary">{{ $episode->durationFormatted }}</span>
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
        </div>
    @endif
    
    @if($series->count() === 0 && $episodes->count() === 0)
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4>no results found</h4>
            <p class="text-muted">try searching with different keywords or browse our <a href="/">latest episodes</a>.</p>
        </div>
    @endif
</div>
@endsection