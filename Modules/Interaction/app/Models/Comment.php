<?php

namespace Modules\Interaction\Models;

use App\Contracts\Interactable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Content\Models\Content;
use Modules\Interaction\Database\Factories\CommentFactory;
use Modules\Interaction\Enums\CommentStatusEnum;
use Modules\Interaction\Observers\CommentObserver;
use Modules\User\Models\User;

/**
 * @property CommentStatusEnum $status
 */
#[ObservedBy(CommentObserver::class)]
class Comment extends Model
{
    use HasFactory , Interactable , Prunable , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'comment_id',
        'ip_address',
        'body',
        'status',
    ];

    public function casts()
    {
        return [
            'status' => CommentStatusEnum::class,
        ];
    }

    public function prunable(): \LaravelIdea\Helper\Modules\Interaction\Models\_IH_Comment_QB|\Illuminate\Database\Eloquent\Builder
    {
        return static::query()->where('created_at', '<', \Illuminate\Support\now()->subWeek())
            ->where('status', '=', CommentStatusEnum::REJECTED)->orWhere('status', '=', CommentStatusEnum::PENDING)->orWhere('deleted_at', '!=', null);
    }

    /**
     * @return BelongsTo<User, Comment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphTo<Content, Comment>
     */
    public function content(): BelongsTo
    {
        return $this->morphTo(Content::class);
    }

    /**
     * @return BelongsTo<Comment, Comment>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'comment_id');
    }

    protected static function newFactory(): CommentFactory
    {
        return CommentFactory::new();
    }

    public function isOld(): bool
    {
        return $this->created_at->diffInMinutes(\Illuminate\Support\now()->subWeek()) >= 0;
    }
}
