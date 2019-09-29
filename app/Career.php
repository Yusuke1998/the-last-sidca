<?php
// Carrera
namespace App;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['name','area_id'];

    public function areas()
    {
    	return $this->belongsTo(Area::class);
    }

    public function programs()
    {
    	return $this->hasMany(Program::class);
    }
}
