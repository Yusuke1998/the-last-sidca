<?php
// Area
namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name','acronym'];

    public function cores()
    {
    	return $this->hasMany(Core::class);
    }

    public function careers()
    {
    	return $this->hasMany(Career::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
