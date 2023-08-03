<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $follow_requests =Followers::with('from_user')->where('to_user_id', auth()->user()->id)
        ->where('accepted',0)->get();

        $followers =Followers::with('from_user','to_user')->where(['to_user_id'=>auth()->user()->id,'accepted'=>1])
        ->orWhereRaw('from_user_id= ? AND accepted = ?',[auth()->user()->id,1])
        ->get();
         $active_follow="primary";

         return view('user.follower',[
            'follow_requests'=>$follow_requests,
            'followers'=>$followers,
            'active_follow'=>$active_follow
         ]);
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
        $follower=Followers::create([
            'from_user_id'=>auth()->user()->id,
            'to_user_id'=>$request->to_user_id,
            'accepted'=>0
        ]);

        //  return redirect()->route('home')
        if ($follower) {
            return redirect()->back()->with([
                'message' => 'Request successfully',
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
     * Display the specified resource.
     */
    public function show(Followers $followers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Followers $followers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $followers=Followers::find($id);
        $followers->update([
            'accepted'=>0
        ]);
        return redirect()->back()->with([
             'message' => 'Accept as friend',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $followers=Followers::destroy($request->id);
        return redirect()->back()->with([
             'message' => 'Accept as friend',
            'alert-type' => 'success',
        ]);
    }
}
