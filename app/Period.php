<?php
// Periodo
namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ['period','title','date_start','date_end'];
}
