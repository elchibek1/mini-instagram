<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['text' => 'required', 'post_id' => 'required', 'approved' => 'boolean']);
        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->post_id = (int)$request['post_id'];
        $comment->text = $request['text'];
        $comment->approved = $request['approved'];
        $comment->save();
        return redirect()->route('posts.index')->with('message', "Comment will be displayed only after approval by the administrator");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete-comment', $comment);
        $comment->delete();
        return redirect()->route('posts.index');
    }
}
