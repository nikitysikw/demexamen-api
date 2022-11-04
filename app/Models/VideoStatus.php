<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoStatus extends Model
{
    protected $table = 'video_status';
    protected $fillable = [
        'id',
        'name'
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
