<?php
// Programa
namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['name'];

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
