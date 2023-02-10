<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group
 * @package App\Models
 */
class Group extends Models
{
    use SoftDeletes, ModelTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'can_access_admin'
    ];

    public $translateable = [];

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'group_permissions',
            'group_id',
            'permission_id'
        );
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
