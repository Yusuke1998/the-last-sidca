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
}
