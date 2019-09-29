<?php
// Area
namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['name','headquarter_id'];

    public function headquarters()
    {
    	return $this->belongsTo(Headquarter::class);
    }

    public function careers()
    {
    	return $this->hasMany(Career::class);
    }
}
