<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'description', 'page_id'
    ];

    public function documents() {
        return $this->hasMany('App\Document');
    }

    public function pages() {
        $this->belongsToMany('App\Page');
    }
}
