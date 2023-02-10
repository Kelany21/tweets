<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Models
{
    use ModelTrait;
    /**
     * @var string[]
     */
    protected $fillable = [
        'permission',
        'controller',
        'slug'
    ];

    public $translateable = [];

    /**
     * @return BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            Group::class,
            'group_permissions',
            'permission_id',
            'group_id'
        );
    }
}
