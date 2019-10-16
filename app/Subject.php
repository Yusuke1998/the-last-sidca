<?php
// Asignatura
namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name','theoretical_hour','practical_hour'];

    public function programs()
    {
    	return $this->belongsToMany(Program::class);
    }
}
