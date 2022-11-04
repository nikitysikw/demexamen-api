<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Video extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'd-m-Y H:i';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'likes',
        'dislikes',
        'user_id',
        'title',
        'body',
        'time_create',
        'name_file',
        'video_status_id',
        'video_category_id'
    ];

    protected $hidden = [
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id');
    }

    /**
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(VideoStatus::class, 'video_status_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
