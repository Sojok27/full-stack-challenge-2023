<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Referral;
use App\Http\Controllers\ResponseController as Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        request()->user()->authorizeRoles(['admin', 'supervisor', 'executive']);
        
        return Response::simple($comment = Comment::create([
            "referral_id" => $request->referral_id,
            "user_id" => $request->post("user_id"),
            "comment" => $request->post("comment"),
        ]), [
            "id" => $comment->id,
            "name" => Auth::user()->name,
            "comment" => $comment->comment,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        request()->user()->authorizeRoles(['admin', 'supervisor', 'executive']);
        $comment = Comment::find($id);
        return Response::simple($comment ? $comment->delete() : false);
    }
}
