@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <img src="/storage/{{ $post->image }}" class="w-100" alt="Full Image">
        </div>

        <div class="col-md-4">
            <div class="d-flex align-items-center">
                <div>
                    <img class="rounded-circle" src="{{ $post->user->profile->profileImage() }}" 
                    class="w-100" alt="profile" style="max-width: 40px;">
                </div>
                <!-- </a> -->
                <h3 class="px-2">
                    <a href="/profile/{{ $post->user->profile->id }}">
                        <strong class="text-dark">{{ $post->user->username }}</strong>
                    </a>
                </h3>
                @if($showFollowBtn)
                <follow-button user-id="{{ $post->user_id }}" follows="{{ $follows }}"></follow-button>
                @endif
            </div>
            <hr>
            <p>{{ $post->caption }}</p>
        </div>
    </div>
</div>
@endsection
