<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_id', 'option_id',
    ];

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }

    public function option()
    {
        return $this->belongsTo('App\SurveyOption');
    }
}
