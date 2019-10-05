<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    protected $fillable = ['person_id','type'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
