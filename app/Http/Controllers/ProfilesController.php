<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index(User $user) 
    {
        $loggedInUser = auth()->user();
        $follows = ($loggedInUser) ? $loggedInUser->following->contains($user->id) : false;

        $showFollowBtn = true;
        if ($loggedInUser->id == $user->id) $showFollowBtn = false;

        $postsCount = Cache::remember(
            'posts.count.' . $user->id,
            now()->addSeconds(30),
            function() use ($user) {
                return $user->posts->count();
            }
        );

        $followersCount = Cache::remember(
            'followers.count.' . $user->id,
            now()->addSeconds(30),
            function() use ($user) {
                return $user->profile->followers->count();
            }
        );

        $followingCount = Cache::remember(
            'following.count.' . $user->id,
            now()->addSeconds(30),
            function() use ($user) {
                return $user->following->count();
            }
        );

        return view('profiles.index', compact('user', 'showFollowBtn', 'follows', 'postsCount', 'followersCount', 'followingCount'));
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }


    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => '',
            'description' => '',
            'url' => '',
            'image' => ''
        ]);

        if (request('image')) {
            $imagePath = request('image')->store('profile', 'public');
    
            $image = Image::make(public_path("storage/{$imagePath}"))->fit('512', '512');
            $image->save();

            $imageArr = ['image' => $imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data, $imageArr ?? [])
        );

        return redirect('/profile/' . $user->id);
    }
}
