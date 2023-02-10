<?php

namespace App\Models;

class GroupPermission extends Models
{
    use ModelTrait;
    /***
     * @var string[]
     */
    protected $fillable = [
        'group_id',
        'permission_id'
    ];

    public $translateable = [];
}
