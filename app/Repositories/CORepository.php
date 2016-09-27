<?php

namespace App\Repositories;

use App\CourseInfo;
use App\COInfo;
use App\CCPInfo;

/**
* 
*/
class CORepository
{
    public function forCourse($course_code)
    {
        return COInfo::where('course_code', $course_code)
                    ->get();
    }

    public function COsNumber($course_code)
    {
        return $this->forCourse($course_code)->count();
    }

    public function nextCOCode($course_code)
    {
        return $course_code."_co_".($this->COsNumber($course_code) + 1);
    }

    /**
     * 得到某一门课的CO的权重的和
     * @param $course_code
     * @return mixed
     */
    public function forCOWeightSum($course_code){
        return COInfo::where('course_code', $course_code)
                ->sum('CO_GR_as_weight');
    }
}
