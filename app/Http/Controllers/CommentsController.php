<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\deleteComment;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CommentsController extends Controller
{
    public function getComments($id) {
        $comments = User::find($id)->getComments->where('parent_id', null)->take(PHP_INT_MAX);
        return view("messages", compact('id', 'comments'));
    }
    public function page($id)
    {
        (request()->input('success')) ? $success = PHP_INT_MAX : $success = 5;
        $comments = User::find($id)->getComments->where('parent_id', null)->take($success);
        $name = User::where('id', $id)->value('email');
        return view("user", compact('name', 'id', 'comments'));
    }

    public function userComments($id)
    {
        $comments = Comment::where('user_id', '=', $id)->get();

        return view("user-comments", [
            'notes' => $comments,
        ]);
    }

    public function read()
    {
        $notes = Comment::latest()->get();

        return view('/user/1', compact('notes'));
    }


    public function create(CommentRequest $request)
    {
        $comment = Comment::create([
            'title' => $request->input('title'),
            "description" => $request->input('comment'),
            "user_id" => $request->input('user_id'),
            "user_to" => $request->input('user_to'),
        ]);
        if ($request->parent && $request->parent !== 'none') {
            $parent = Comment::find($request->parent);
            $parent->appendNode($comment);
        }


        return redirect('/user/' . $request->input('user_to'));
    }


    public function delete(deleteComment $request)
    {
        $comment = Comment::find($request->input('note_id'));
        if ($comment->user_to == Auth::user()->id | $comment->user_id == Auth::user()->id) {
            $comment->delete();
        }
        return redirect('/user/' . $request->input('user_to'));
    }
}
