<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'body',
        'video_id',
        'user_id',
        'time_create'
    ];

    protected $casts = [
        "time_create" => 'datetime'
    ];


    /**
     * @return string
     */
    public function getTimeAttribute()
    {
        return $this->time_create->format('d-m-Y H:i');
    }

    /**
     * @return BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
