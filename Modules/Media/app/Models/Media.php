<?php

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Enums\MediaTypeEnum;

// use Modules\Media\Database\Factories\MediaFactory;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'path',
        'type',
        'size',
        'mime_type',
        'user_id',
    ];


    protected $casts = [
        'type' => MediaTypeEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(\Modules\User\Models\User::class);
    }


    // protected static function newFactory(): MediaFactory
    // {
    //     // return MediaFactory::new();
    // }
}
