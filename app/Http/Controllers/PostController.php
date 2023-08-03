<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NewNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.paginate
     */
    public function index()
    {
       try{
        $posts= Post:paginate(9);
        $posts = Post::with(['comments' => function($q){
            $q -> select('id','post_id','comment');
        }])->get();
        return view('layouts.home',[
            'posts'=>$posts
        ]);
    }catch(\Exception $e){
        return redirect()->route('home');

    }

        //  return $posts;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->hasFile('filename')){
            $file =$request->file('filename');
            $fileName=time().$file->getClientOriginalName();
            $file->move(public_path().'/images/posts',$fileName);
        }

        $data=Post::create([
            'user_id'=>auth()->user()->id,
            'image_path'=>$fileName,
            'body'=>$request->body
        ]);
        $data =[
            'user_id'=> Auth::id(),
            'user_name'=> Auth::user()->name,
            'comment'=>$request->comment,
            'post_id'=>$request->post_id
        ];

        event(new NewNotification($data));

        if ($data) {
            return redirect()->route('home')->with([
                'message' => 'Post created successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }

        try{

        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error'=>$e->getMessage()]);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post=Post::with('user')->findOrFail($id);
        $user = auth()->user();
        return view('frontend.post.show', ['post'=>$post]);
        // if (auth()->user()->can('show',$post)){

        // }else{
        //     return redirect()->route('home');
        // }


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post =Post::whereId($id)->first();
        if (auth()->user()->can('show',$post)){

            return view('frontend.post.edit',['post'=>$post]);
        }
        else{
            return redirect()->route('home');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post =Post::whereId($id)->first();
        $fileName="";
        if ($request->hasFile('filename')){
            if($post->image_path != ''){
                if(File::exists('images/posts/'.$post->image_path)){
                    unlink('images/posts/'.$post->image_path);
                }
            }
        }

        $post->update([
            'image_path'=>$fileName ? $fileName :$post->image_path,
            'body'=>$request->body
        ]);

        if ($post) {
            return redirect()->route('home')->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post =Post::whereId($id)->first();
        $post->delete();

        return redirect()->route('home')->with([
            'message' => 'Post Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }
}
