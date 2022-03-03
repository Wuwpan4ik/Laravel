<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\deleteComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentsController extends Controller
{
    public function page($id)
    {
        $comments = DB::table('Comments')->where('to_user', '=', $id)->get();
        $name = DB::table('users')->where('id', '=', $id)->value('email');

        return view("user", [
            'notes' => $comments,
            'id' => $id,
            'name' => $name
        ]);
    }

    public function userComments($id)
    {
        $comments = DB::table('Comments')->where('id_user', '=', $id)->get();

        return view("user-comments", [
            'notes' => $comments,
        ]);
    }

    public function addComment(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->title = $request->input('title');
        $comment->description = $request->input('comment');
        $comment->id_user = $request->input('id_user');
        $comment->to_user = $request->input('to_user');

        $comment->save();

        return redirect('/user/' . $request->input('to_user'));
    }

    public function deleteComment(deleteComment $request)
    {
        $comment = DB::table('Comments');
        $comment->delete($request->input('id_note'));
        return redirect('/user/' . $request->input('to_user'));
    }
}
