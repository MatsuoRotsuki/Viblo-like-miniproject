<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        $this->validate($request, [
            'commentbody' => 'required',
        ]);

        $request->user()->comments()->create([
            'post_id' => $post->id,
            'commentbody' => $request->commentbody,
        ]);

        return back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back();
    }
}
