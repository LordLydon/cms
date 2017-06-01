<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'description', 'storage_path', 'keywords', 'file_extension',
    ];

    public function category() {
        return $this->belongsTo('App\Category');
    }
}
