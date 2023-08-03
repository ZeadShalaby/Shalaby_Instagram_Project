<?php

namespace App\Http\Controllers\Comment;

use App\Events\NewNotification;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = Post::with('user')->find($request->post_id);
        Comment::create([
            'post_id'=>$request->post_id,
            'user_id'=>auth()->user()->id,
            'comment'=>$request->comment
        ]);
        // if(policy(Comment::class)->create(auth()->user(),$post)){

            $data =[
                'user_id'=> Auth::id(),
                'user_name'=> Auth::user()->name,
                'comment'=>$request->comment,
                'post_id'=>$request->post_id
            ];

            event(new NewNotification($data));
            return redirect()->back()->with([
                'message' => 'Comment add successfully',
                'alert-type' => 'success',
            ]);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment =Comment::whereId($id)->first();
        if(auth()->user()->can('delete',$comment)){
            $comment->delete();
            return redirect()->back()->with([
                'massage'=>'comment delete'
            ]);
        }
    }
}
