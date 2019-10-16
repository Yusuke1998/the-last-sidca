<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicTraining extends Model
{
    protected $fillable = ['type','description','start','end','hours','teacher_id'];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }
}
