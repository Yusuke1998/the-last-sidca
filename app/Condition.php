<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = ['name','contract','date_start','date_next'];

    public function teachers()
    {
    	return $this->hasMany(Teacher::class);
    }
}
