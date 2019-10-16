<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dedication extends Model
{
    protected $fillable = ['name'];

    public function teachers()
    {
    	return $this->hasMany(Teacher::class);
    }
}
