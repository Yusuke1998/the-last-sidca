<?php
// Area
namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name'];

    public function cores()
    {
    	return $this->belongsToMany(Core::class);
    }

    public function careers()
    {
    	return $this->belongsToMany(Career::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
