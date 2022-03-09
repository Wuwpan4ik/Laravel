<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\deleteComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CommentsController extends Controller
{
    public function page($id, $success = False)
    {
        $comments = Comment::where('user_to', '=', $id)->skip(0)->take(2)->get();
        $name = DB::table('users')->where('id', '=', $id)->value('email');

        $success = request()->input('success');
        if ($success != False) {
            $comments_all = $comments->concat(Comment::skip(2)->take(PHP_INT_MAX)->get());
            $comments = $comments_all;
            return view("user", [
                'notes' => $comments,
                'id' => $id,
                'name' => $name
            ]);
        }

        return view("user", [
            'notes' => $comments,
            'id' => $id,
            'name' => $name
        ]);
    }

    public function userComments($id)
    {
        $comments = DB::table('Comments')->where('user_id', '=', $id)->get();

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
        if ($comment->user_to == Auth::user()->id && $comment->user_id == Auth::user()->id) {
            $comment->delete();
        }
        return redirect('/user/' . $request->input('user_to'));
    }
}
