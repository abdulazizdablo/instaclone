@extends('layouts.app')

@section('content')
<div class="container">
    @if($postsCount != 0)
        @foreach($posts as $post)
            
        <div class="row my-4">
            
            <div class="col-md-6 offset-3">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100" alt="Full Image">
                </a>
                <div class="d-flex pt-2 mb-4 align-items-center">
                    <img class="rounded-circle pr-2" src="{{ $post->user->profile->profileImage() }}" 
                    class="w-100" alt="profile" style="max-width: 40px;">
                    <a href="/profile/{{ $post->user->profile->id }}">
                        <strong class="text-dark">{{ $post->user->username }}</strong>
                    </a>
                </div>
            </div>
        </div>

        @endforeach
        <div class="row">
            <div class="d-flex col-md-12 justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>  
    @else
        <div class="d-flex justify-content-center my-5"> Follow Some Interesting People.</div>  
        <div class="row justify-content-center">
        @foreach($topUsers as $user)
            <div class="col-2 text-center">
                <img class="rounded-circle" src="{{ $user->profile->profileImage() }}" 
                    class="w-100" alt="profile" style="max-width: 80px;">
                <div>
                    <a href="/profile/{{ $user->profile->id }}">
                        <strong class="text-dark">{{ $user->username }}</strong>
                    </a>
                    <div>
                        <strong>{{ $user->profile->followers->count() }}</strong> followers
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @endif

</div>
@endsection
