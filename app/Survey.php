<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id', 'title', 'question',
    ];

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function options()
    {
        return $this->hasMany('App\SurveyOption');
    }

    public function results()
    {
        return $this->hasMany('App\SurveyResult');
    }
}
