@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 p-2 text-center">
            <img class="rounded-circle w-50" src="{{ $user->profile->profileImage() }}" alt="profile">
        </div>
        <div class="col-md-8 pt-2">
            <div class="d-flex justify-content-between align-items-baseline">

                <div class="d-flex align-items-center mb-4">
                    <div class="h4 mr-4">{{ $user->username }}</div>

                    @if($showFollowBtn)
                        <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                    @endif
                </div>

                @can('update', $user->profile)
                <a href="/p/create">Add New Post</a>
                @endcan 
            </div>

            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"><strong>{{ $postsCount }}</strong> posts</div>
                <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
            </div>
            <div>
                @if(!is_null($user->profile->title))
                <div><strong>{{ $user->profile->title }}</strong></div>
                @endif
                <div>{{ $user->profile->description }}</div>
                <div><strong><a href="">{{ $user->profile->url }}</a></strong></div>
            </div>
        </div>
        <div class="row pt-5">
            @foreach($user->posts as $post)
            <div class="col-md-4 pb-4">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100" alt="post image">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection