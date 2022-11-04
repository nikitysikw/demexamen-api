<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    protected $table = 'video_categorys';

    protected $fillable = [
        'id',
        'name'
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
