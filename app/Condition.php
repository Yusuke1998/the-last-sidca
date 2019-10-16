<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = ['name'];

    public function teachers()
    {
    	return $this->hasMany(Teacher::class);
    }
}
