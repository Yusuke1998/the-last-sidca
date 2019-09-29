<?php
// Sede
namespace App;

use Illuminate\Database\Eloquent\Model;

class Headquarter extends Model
{
    protected $fillable = ['name'];

    public function areas()
    {
    	return $this->hasMany(Area::class);
    }
}
