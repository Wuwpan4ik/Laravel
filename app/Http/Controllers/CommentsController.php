<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\deleteComment;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CommentsController extends Controller
{
    public function page($id)
    {
        $comments = Comment::where('user_to', '=', $id)->whereNull('parent_id')->withDepth()->with('children')->paginate(5, 1);
        //$comments = Comment::where('user_to', '=', $id)->whereNull('parent_id')->withDepth()->with('children')->get()->toTree();

        $name = DB::table('users')->where('id', '=', $id)->value('email');

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

    public function create()
    {
        $notes = Comment::latest()->get();

        return view('/user/1', compact('notes'));
    }


    public function addComment(CommentRequest $request)
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


    public function deleteComment(deleteComment $request)
    {
        $comment = DB::table('Comments');
        $comment->delete($request->input('id_note'));
        return redirect('/user/' . $request->input('user_to'));
    }
}
