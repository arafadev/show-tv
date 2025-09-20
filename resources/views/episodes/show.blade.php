@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body p-0">
                <video class="video-player" controls poster="{{ $episode->thumbnailUrl }}">
                    <source src="{{ $episode->videoUrl }}" type="video/mp4">
                   your browser does not support the video tag
                </video>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="mb-1">{{ $episode->title }}</h4>
                        <p class="text-muted mb-2">
                            <a href="{{ route('series.show', $episode->series) }}" class="text-decoration-none">
                                {{ $episode->series->title }}
                            </a>
                            • Season {{ $episode->season_number }}, Episode {{ $episode->episode_number }}
                        </p>
                        <div class="d-flex align-items-center text-muted small">
                            <span class="me-3">
                                <i class="fas fa-clock"></i> {{ $episode->durationFormatted }}
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i> {{ $episode->airing_time->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="button" 
                                class="btn btn-outline-primary like-dislike-btn {{ $has_liked ? 'active' : '' }}" 
                                onclick="toggleLike({{ $episode->id }}, true)">
                            <i class="fas fa-thumbs-up"></i>
                            <span id="likesCount">{{ $episode->likesCount }}</span>
                        </button>
                        <button type="button" 
                                class="btn btn-outline-danger like-dislike-btn {{ $has_disliked ? 'active' : '' }}" 
                                onclick="toggleLike({{ $episode->id }}, false)">
                            <i class="fas fa-thumbs-down"></i>
                            <span id="dislikesCount">{{ $episode->dislikesCount }}</span>
                        </button>
                    </div>
                </div>
                
                <hr>
                
                <h6>Description</h6>
                <p>{{ $episode->description }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">More from {{ $episode->series->title }}</h6>
            </div>
            <div class="card-body p-0">
                @if($related_episodes->count() > 0)
                    @foreach($related_episodes as $episode)
                        <div class="d-flex p-3 border-bottom">
                            <div class="flex-shrink-0 me-3">
                                <img src="{{ $episode->thumbnailUrl }}" 
                                     alt="{{ $episode->title }}" 
                                     style="width: 80px; height: 45px; object-fit: cover; border-radius: 4px;">
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <h6 class="mb-1 small">
                                    <a href="{{ route('episodes.show', $episode) }}" 
                                       class="text-decoration-none">
                                        {{ Str::limit($episode->title, 40) }}
                                    </a>
                                </h6>
                                <p class="mb-1 small text-muted">
                                    S{{ $episode->season_number }}E{{ $episode->episode_number }} • 
                                    {{ $episode->durationFormatted }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-3 text-center text-muted">
                        no other episodes available
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleLike(episodeId, isLike) {
    const likeBtn = $('.like-dislike-btn').eq(0);
    const dislikeBtn = $('.like-dislike-btn').eq(1);
    const likesCount = $('#likesCount');
    const dislikesCount = $('#dislikesCount');
    
    $.post(`/episodes/${episodeId}/toggle-like`, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        is_like: isLike
    })
    .done(function(response) {
        if (response.success) {
            // Update counts
            likesCount.text(response.likesCount);
            dislikesCount.text(response.dislikesCount);
            
            // Update button states
            likeBtn.toggleClass('active', response.has_liked);
            dislikeBtn.toggleClass('active', response.has_disliked);
            
            // Show success message
            let actionText = '';
            if (response.action === 'liked') actionText = 'Liked episode!';
            else if (response.action === 'disliked') actionText = 'Disliked episode!';
            else if (response.action === 'removed') actionText = 'Removed your rating!';
            
            $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
              actionText +
              '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>')
              .prependTo('main').delay(2000).fadeOut();
        }
    })
    .fail(function() {
        alert('error happend, please try again');
    });
}
</script>
@endpush