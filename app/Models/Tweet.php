<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group
 * @package App\Models
 */
class Tweet extends Models
{
    use SoftDeletes, ModelTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'text',
        'user_id',
        'update_count',
        'status'
    ];

    public $translateable = [];

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function seenUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_sees',
            'tweet_id',
            'user_id'
        );
    }
}
