<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_id', 'option', 'value',
    ];

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }

    public function results()
    {
        return $this->hasMany('App\SurveyResult', 'option_id');
    }
}
