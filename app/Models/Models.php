<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * @package App\Models
 */
class Models extends Model
{

    public $translateable = [
        'name', 'meta_keywords', 'meta_description'
    ];

    /***
     * @return mixed
     */
    public function getNameAttribute($val)
    {
        return $this->{'name_' . config('app.locale')} ?? $val;
    }

    /***
     * @return mixed
     */
    public function getMetaKeywordsAttribute($val)
    {
        return $this->{'meta_keywords_' . config('app.locale')} ?? $val;
    }

    /***
     * @return mixed
     */
    public function getMetaDescriptionAttribute($val)
    {
        return $this->{'meta_description_' . config('app.locale')} ?? $val;
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
