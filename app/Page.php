<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'content', 'is_private', 'position', 'user_id', 'page_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function categories()
    {
        return $this->hasMany('App\Category');
        //return $this->belongsToMany('App\Category');
    }

    public function survey()
    {
        return $this->hasOne('App\Survey');
    }

    public function superpage()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public function topSubpages()
    {
        return $this->subpages()->where('position', 'top');
    }

    public function subpages()
    {
        return $this->hasMany('App\Page', 'page_id');
    }

    public function leftSubpages()
    {
        return $this->subpages()->where('position', 'left');
    }

    public function rightSubpages()
    {
        return $this->subpages()->where('position', 'right');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getPositionAttribute($value)
    {
        switch ($value) {
            case 'top' :
                return 'Superior';
                break;
            case 'left':
                return 'Izquierda';
                break;
            case 'right':
                return 'Derecha';
                break;
            case 'none':
                return 'No Mostrar';
                break;
        }
    }
}
