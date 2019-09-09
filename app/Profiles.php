<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profiles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * User relation
     */
    public function user()
    {
    	return $this->hasMany('App\Profiles', 'id_profile');
    }
}
