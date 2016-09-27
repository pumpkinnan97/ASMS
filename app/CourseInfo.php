<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseInfo extends Model
{
    protected $table = "course_infos";


    /**
     * Do not maintain the timestamps auto.
     *
     * @var string
     */
    public $timestamps = false;
    protected $fillable=['course_code','name','english_name','total_hours','credit','type','major','course_group','prerequisite_course',
    'description','english_description','co_achievement_scale','author','test_way','advice_books','edit_date','cd_name'];
}
