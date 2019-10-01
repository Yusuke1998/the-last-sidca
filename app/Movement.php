<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['name'];

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
