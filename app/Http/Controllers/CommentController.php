<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController
{
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'video_id' => 'required|integer',
            'body' => 'required|string'
        ]);

        if ($validated->fails()) {
            return ResponseController::toResponseJSON(400, $validated->getMessageBag());
        }

        $data = $validated->valid();

        $user = User::whereToken($request->bearerToken())->first();

        Comment::create([
            'body' => $data['body'],
            'user_id' => $user->id,
            'video_id' => $data['video_id']
        ]);
    }
}
