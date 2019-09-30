<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
	protected $fillable = ['person_id'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
