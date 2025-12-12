<?php

namespace Modules\Interaction\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Content\Models\Content;
use Modules\User\Models\User;

// use Modules\Interaction\Database\Factories\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'comment_id',
        'ip_address',
        'title',
        'body',
    ];

    /**
     * @return BelongsTo<User, Comment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Content, Comment>
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * @return BelongsTo<Comment, Comment>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'comment_id');
    }

    // protected static function newFactory(): CommentFactory
    // {
    //     // return CommentFactory::new();
    // }
}
