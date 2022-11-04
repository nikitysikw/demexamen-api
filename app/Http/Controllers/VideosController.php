<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VideosController
{
    public function index()
    {
        return response()->json(
            Video::orderBy('time_create', 'desc')->get()
        );
    }

    public function showMy(Request $request)
    {
        $userVideos = Collection::make();

        $temp = User::whereToken($request->bearerToken())
            ->first()
            ->videos()
            ->orderBy('count', 'desc')
            ->get(DB::raw('id, title, body, (likes + dislikes) as count, likes, dislikes, time_create, video_category_id, video_status_id'));

        foreach ($temp as $item) {
            $userVideos->add(
                [
                    'id' => $item->id,
                    'title' => $item->title,
                    'body' => $item->body,
                    'likes' => $item->likes,
                    'dislikes' => $item->dislikes,
                    'time_create' => $item->getTimeAttribute(),
                    'video_category' => $item->category()->first()->name,
                    'video_status' => $item->status()->first()->name,
                ]
            );
        }

        return $userVideos;
    }

    public function showTen(Request $request)
    {
        $videos = Collection::make();

        $temp = Video::whereVideoStatusId(1)->limit(10)->select(['id', 'title', 'name_file', 'time_create'])->get();

        foreach ($temp as $item) {
            $videos->add(
                [
                    'id' => $item->id,
                    'title' => $item->title,
                    'name_file' => $item->name_file,
                    'time_create' => $item->getTimeAttribute(),
                ]
            );
        }

        return response()->json(
            $videos
        );
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'string',
            'video_category_id' => 'required|integer',
            'file' => 'required|string'
        ]);

        if ($validated->fails()) {
            return ResponseController::toResponseJSON(400, $validated->getMessageBag());
        }

        $data = $validated->valid();

        $userId = User::whereToken($request->bearerToken())->first()->id;

        Video::create(
            [
                'title' => $data['title'],
                'body' => $data['body'],
                'name_file' => $data["file"],
                'user_id' => $userId,
                'video_category_id' => $data['video_category_id']
            ]
        );
    }

    public function show(Video $video)
    {
        $data = Collection::make();
        $comments = Collection::make();

        $data->add($video->only(['title', 'body', 'likes', 'dislikes', 'time_create']));

        foreach ($video->comments()->orderBy('time_create', 'desc')->get() as $comment) {
            $comments->add(
                [
                    'body' => $comment->body,
                    'username' => $comment->user()->first()->username,
                    'time_create' => $comment->getTimeAttribute(),
                ]
            );
        }

        $data->add($comments);


        return response()->json(
            $data
        );
    }
}
