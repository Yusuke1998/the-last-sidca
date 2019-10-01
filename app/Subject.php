<?php
// Asignatura
namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name','theoretical_hour','practical_hour'];

    public function careers()
    {
    	return $this->belongsToMany(Career::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
