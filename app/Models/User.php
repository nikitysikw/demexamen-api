<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id',
        'email',
        'password',
        'username',
        'token',
        'rolle_id'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * @return HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return BelongsTo
     */
    public function rolle()
    {
        return $this->belongsTo(Rolle::class)->first();
    }
}
