<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class teach_plan extends Model
{
    protected $table='teach_plan';
    public $timestamps=false;
    protected $fillable=['course_code','cm','teach_hours','teach_way','teach_requirement','teach_content'];
    public function teach_plan(){
        return $this->hasOne('App/teach_plan','cm_code');
    }
}
