<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Http\Request;

class PostVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post, $vote, Request $request)
    {
        if ($post->votedBy($request->user()))
        {
            if(!$post->votes->where('user_id', $request->user()->id)->contains('vote',$vote))
            {
                $request->user()->votes()->where('post_id', $post->id)->update(['vote' => $vote]);
                return back();
            } else {
                return dd('Error: Forbidden');
            }
        }

        if ($vote == 'up'){
            $post->votes()->create([
                'user_id' => $request->user()->id,
                'vote' => $vote,
            ]);

            return back();
        }
        elseif($vote == 'down'){
            $post->votes()->create([
                'user_id' => $request->user()->id,
                'vote' => $vote,
            ]);

            return back();
        }
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->votes()->where('post_id', $post->id)->delete();

        return back();
    }
}
