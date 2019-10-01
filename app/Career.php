<?php
// Carrera
namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['name'];

    public function areas()
    {
    	return $this->belongsToMany(Area::class);
    }

    public function subjects()
    {
    	return $this->belongsToMany(Subject::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
