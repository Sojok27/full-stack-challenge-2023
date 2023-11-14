<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Comment;
use App\Referral;

class CommentResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function store($request)
    {
        Comment::create([
            "referral_id" => Referral::where('reference_no', $request->post("referral_id"))->get()->first()->id,
            "user_id" => $request->post("user_id"),
            "comment" => $request->post("comment"),
        ]);
        return response()->json([
            "status" => "OK",
            "statusCode" => 1,
            "message" => "Created Successfully"]
            , 200);
    }
}
