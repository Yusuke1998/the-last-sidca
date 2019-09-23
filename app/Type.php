<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name'];

    public function people()
    {
    	return $this->belongsToMany(Person::class);
    }
}
