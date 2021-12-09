<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Profile;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index() {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate('5');

        $postsCount = $posts->count();

        //get top users
        $allUsers = User::get();

        $usersArr = [];

        foreach ($allUsers as $user) {
            $count = $user->profile->followers->count();
            $usersArr[$user->id] = $count;
        }
        
        arsort($usersArr);
        $topUsersId = array_slice(array_keys($usersArr), 0, 5);
        
        $topUsers = [];
        foreach ($topUsersId as $userId) {
            $user = User::where('id', $userId)->first();
            array_push($topUsers, $user);
        }

        return view('posts.index', compact('posts', 'postsCount', 'topUsers'));
    }


    public function create()
    {
        return view('posts.create');
    }


    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit('1200', '1200');
        $image->save();

        Auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        return redirect('/profile/' . Auth()->user()->id);
    }

    public function show(\App\Post $post)
    {
        $loggedInUser = auth()->user();
        $follows = ($loggedInUser) ? $loggedInUser->following->contains($post->user_id) : false;

        $showFollowBtn = true;
        if ($loggedInUser->id == $post->user_id) $showFollowBtn = false;

        return view('posts.show', compact('post', 'showFollowBtn', 'follows'));
    }
}
