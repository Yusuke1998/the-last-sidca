<?php
// Profesor
namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
	protected $fillable = ['person_id'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function titles()
    {
    	return $this->belongsToMany(Title::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
