<?php
// Programa
namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
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

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
