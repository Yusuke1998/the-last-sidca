<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $fillable = ['name','area_id','program_id'];

    public function area()
    {
    	return $this->belongsTo(Area::class);
    }

    public function program()
    {
    	return $this->belongsTo(Program::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
