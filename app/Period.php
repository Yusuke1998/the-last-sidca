<?php
// Periodo
namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['period'];

    public function histories()
    {
    	return $this->hasMany(Historic::class);
    }
}
