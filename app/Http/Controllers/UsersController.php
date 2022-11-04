<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsersController
{
    // registration
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:users,username',
                'email' => 'required|email:rfc|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
                'password' => 'required',
                'repeatPassword' => 'required|same:password',
            ]
        );

        if ($validated->fails()) {
            return ResponseController::toResponseJSON(400, $validated->getMessageBag());
        }

        $data = $validated->valid();
        $data['password'] = Hash::make($data['password']);

        User::create(["username" => $data['username'], "email" => $data['email'], "password" => $data['password'], "token" => Str::random(60)]);
        $user = User::get()->last();

        return ResponseController::toResponseJSON(200,
            [
                "user" => $user,
                "videos" => $user->videos(),
                "rolle" => $user->rolle(),
            ]
        );
    }

    public function logout(Request $request)
    {
        $user = User::where('token', '=', $request->bearerToken())->select()->first();

        $user->token = null;
        $user->save();

        return ResponseController::toResponseJSON(200, null);
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validated->fails()) {
            return ResponseController::toResponseJSON(400, $validated->getMessageBag());
        }

        if (Auth::attempt($validated->valid())) {

            Auth::user()->token = Str::random(60);
            Auth::user()->save();

            return ResponseController::toResponseJSON(
                200,
                [
                    "user" => Auth::user(),
                    "videos" => Auth::user()->videos(),
                    "rolle" => Auth::user()->rolle()
                ]
            );
        }

        return ResponseController::toResponseJSON(400, ["email" => ["email or password not correct"]]);
    }

    public function changeStatusVideo(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'video' => 'required|integer',
            'new_status' => 'required|integer',
        ]);

        if ($validated->fails()) {
            return ResponseController::toResponseJSON(400, $validated->getMessageBag());
        }

        $data = $validated->valid();

        $user = User::whereToken($request->bearerToken())->first();

        if ($user->rolle_id === 1) {
            $video = Video::find($data['video']);

            $video->video_status_id = $data['new_status'];
            $video->save();

            return ResponseController::toResponseJSON(200, Video::find($data['video']));
        } else {
            return ResponseController::toResponseJSON(400, ["No permission"]);
        }
    }
}
