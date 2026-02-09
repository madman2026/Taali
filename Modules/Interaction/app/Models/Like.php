<?php

namespace Modules\Interaction\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Content\Models\Content;
use Modules\User\Models\User;

class Like extends Model
{
    use Prunable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'content_id',
        'user_id',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->morphTo(Content::class);
    }
}
