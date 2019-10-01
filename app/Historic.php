<?php
// Historico
namespace App;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $fillable = [
    	'date_start','date_end','workload','condition','category','dedication','request','academic',
    	'approval','observations','teacher_id','movement_id','headquarter_id','core_id','area_id',
    	'career_id','program_id','period_id','subject_id'
    ];

    public function teacher()
    {
    	return $this->belongsTo(Teacher::class);
    }

    public function movement()
    {
    	return $this->belongsTo(Movement::class);
    }

    public function headquarter()
    {
    	return $this->belongsTo(Headquarter::class);
    }

    public function core()
    {
    	return $this->belongsTo(Core::class);
    }

    public function area()
    {
    	return $this->belongsTo(Area::class);
    }

    public function career()
    {
    	return $this->belongsTo(Career::class);
    }

    public function program()
    {
    	return $this->belongsTo(Program::class);
    }

    public function period()
    {
    	return $this->belongsTo(Period::class);
    }

    public function subject()
    {
    	return $this->belongsTo(Subject::class);
    }
}
