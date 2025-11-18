<?php

namespace Modules\Interaction\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Content\Models\Content;
use Modules\User\Models\User;

class View extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'content_id',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    // protected static function newFactory(): ViewFactory
    // {
    //     // return ViewFactory::new();
    // }
}
