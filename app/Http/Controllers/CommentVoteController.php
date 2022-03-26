<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentVoteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Comment $comment, $vote, Request $request)
    {
        if ($comment->votedBy($request->user())){
            if (!$comment->votes->where('user_id', $request->user()->id)->contains('vote', $vote))
            {
                $request->user()->votes2()->where('comment_id', $comment->id)->update(['vote' => $vote]);

                return back();
            } else {
                return dd('Error: Forbiden');
            }
        }

        if ($vote == 'up'){
            $comment->votes()->create([
                'user_id' => $request->user()->id,
                'vote' => $vote,
            ]);

            return back();
        }

        if ($vote == 'down'){
            $comment->votes()->create([
                'user_id' => $request->user()->id,
                'vote' => $vote,
            ]);

            return back();
        }
    }

    public function destroy(Comment $comment, Request $request)
    {
        $request->user()->votes2()->where('comment_id', $comment->id)->delete();

        return back();
    }
}
