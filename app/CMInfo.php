<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CMInfo extends Model
{
    protected $table='cm_infos';
    public $timestamps=false;
    protected $fillable=['cm_code','course_code','name','EN_name','description','english_description'];
}
