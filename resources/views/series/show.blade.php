@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <img src="{{ $series->posterImageUrl }}" class="card-img-top" alt="{{ $series->title }}">
            <div class="card-body">
                <h5 class="card-title">{{ $series->title }}</h5>
                <p class="card-text">{{ $series->description }}</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">
                        <i class="fas fa-calendar"></i> 
                        {{ $series->airing_time->format('M d, Y') }}
                    </small>
                    <small class="text-muted">
                        <i class="fas fa-users"></i> 
                        <span id="followers_count">{{ $series->followers_count }}</span> followers
                    </small>
                </div>
                
                <button type="button" 
                        class="btn follow-btn w-100 {{ $is_following ? 'btn-outline-danger' : 'btn-primary' }}"
                        onclick="toggleFollow({{ $series->id }})">
                    <i class="fas {{ $is_following ? 'fa-user-minus' : 'fa-user-plus' }}"></i>
                    <span id="followText">{{ $is_following ? 'Unfollow' : 'Follow' }}</span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Episodes ({{ $series->episodes->count() }})</h3>
        </div>
        
        @if($series->episodes->count() > 0)
            <div class="row">
                @foreach($series->episodes->groupBy('season_number') as $seasonNumber => $episodes)
                    <div class="col-12 mb-4">
                        <h5 class="mb-3">Season {{ $seasonNumber }}</h5>
                        <div class="row">
                            @foreach($episodes as $episode)
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <div class="card episode-card">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <img src="{{ $episode->thumbnailUrl }}" 
                                                     class="card-img thumbnail" alt="{{ $episode->title }}">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title mb-1">
                                                        Episode {{ $episode->episode_number }}: {{ $episode->title }}
                                                    </h6>
                                                    <p class="card-text small text-muted mb-2">
                                                        {{ Str::limit($episode->description, 80) }}
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">{{ $episode->durationFormatted }}</small>
                                                        <a href="{{ route('episodes.show', $episode) }}" 
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fas fa-play"></i> Watch
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <h5>No episodes available</h5>
                <p class="text-muted">Episodes will be added soon!</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFollow(seriesId) {
    const btn = $('.follow-btn');
    const originalHtml = btn.html();
    
    btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');
    
    $.post(`/series/${seriesId}/toggle-follow`, {
        _token: $('meta[name="csrf-token"]').attr('content')
    })
    .done(function(response) {
        if (response.success) {
            const isFollowing = response.is_follow;
            const followText = $('#followText');
            const icon = btn.find('i');
            const followers_count = $('#followers_count');
            
            if (isFollowing) {
                btn.removeClass('btn-primary').addClass('btn-outline-danger');
                icon.removeClass('fa-user-plus').addClass('fa-user-minus');
                followText.text('Unfollow');
            } else {
                btn.removeClass('btn-outline-danger').addClass('btn-primary');
                icon.removeClass('fa-user-minus').addClass('fa-user-plus');
                followText.text('Follow');
            }
            
            followers_count.text(response.followers_count);
            
            // Show success message
            $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
              response.message +
              '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>')
              .prependTo('main').delay(3000).fadeOut();
        }
    })
    .fail(function() {
        alert('Error occurred. Please try again.');
    })
    .always(function() {
        btn.prop('disabled', false).html(originalHtml);
    });
}
</script>
@endpush