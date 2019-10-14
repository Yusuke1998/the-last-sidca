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

    public function cores()
    {
    	return $this->hasMany(Core::class);
    }

    public function extensions()
    {
    	return $this->hasMany(Extension::class);
    }

    public function territorial_classroom()
    {
    	return $this->hasMany(TerritorialClassroom::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
