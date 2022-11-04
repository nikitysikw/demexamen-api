<?php

namespace App\Http\Controllers;

use App\Models\VideoStatus;

class VideoStatusController
{
    public function index()
    {
        return response()->json(
            VideoStatus::orderBy('id')->get(),
        );
    }
}
