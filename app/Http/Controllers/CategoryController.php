<?php

namespace App\Http\Controllers;

use App\Models\VideoCategory;

class CategoryController
{
    public function index()
    {
        return response()->json(VideoCategory::orderBy('id')->get());
    }
}
