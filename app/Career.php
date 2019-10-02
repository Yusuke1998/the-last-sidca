<?php
// Carrera
namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['name','area_id'];

    public function area()
    {
    	return $this->belongsTo(Area::class);
    }

    public function subjects()
    {
    	return $this->belongsToMany(Subject::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
