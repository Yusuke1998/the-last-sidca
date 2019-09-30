<?php
// Sede
namespace App;

use Illuminate\Database\Eloquent\Model;

class Headquarter extends Model
{
    protected $fillable = ['name'];

    public function cores()
    {
    	return $this->hasMany(Core::class);
    }
}
