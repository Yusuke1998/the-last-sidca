<?php
// Area
namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name','acronym','headquarter_id'];

    public function headquarter()
    {
        return $this->belongsTo(Headquarter::class);
    }

    public function cores()
    {
    	return $this->hasMany(Core::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function extensions()
    {
        return $this->hasMany(Extension::class);
    }

    public function territorial_classrooms()
    {
    	return $this->hasMany(TerritorialClassroom::class);
    }

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
