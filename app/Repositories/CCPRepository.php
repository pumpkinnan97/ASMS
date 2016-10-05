<?php

namespace App\Repositories;

use App\CourseInfo;
use App\CCPInfo;

/**
* 
*/
class CCPRepository
{
    public function forCourseAtLevel($course_code, $level)
    {
        return CCPInfo::where('course_code', $course_code)
                        ->where('level', $level)
                        ->get();
    }

    public function forChildNode($CCP_code, $cur_level)
    {
        return CCPInfo::where('ccp_code', 'REGEXP', $CCP_code."_")
                        ->where('level', $cur_level)
                        ->get();
    }

    public function forTree($course_code)
    {
        $resultSet = CCPInfo::where('course_code', $course_code)->get(['id','ccp_code','is_leaf_ccp','name','description','standard_score','expected_score','actual_score','level']);

        return empty($resultSet)? false : $resultSet;
    }

    public function forHighestLevel($CCP_code)
    {
        return CCPInfo::distinct('level')
                        ->where('$CCP_code', 'like', $CCP_code)
                        ->get()
                        ->count();
    }

    public function nextNumAtLevel($course_code, $level)
    {
        return $this->forCourseAtLevel($course_code, $level)->count() + 1;
    }

    public function leafCCPforCourse($course_code)
    {
        return CCPInfo::where('course_code', $course_code)
                      ->where('is_leaf_ccp', 1)
                      ->get(['name','id']);
    }

    public function leafCCPforCourseByBaseGroup($course_code){
        $res = array();
        $sheetName = CCPInfo::where('course_code', $course_code)
            ->where('is_leaf_ccp', 0)
            ->where('level', 1)
            ->get(['name','id','ccp_code']);
        foreach ($sheetName as $key => $value){
            $res[$value['name'].'_'.$value['id']] = CCPInfo::where('ccp_code', 'like', $value['ccp_code']."%%")
                ->where('is_leaf_ccp', 1)
                ->get(['name','id']);
        }
        return $res;
    }
}
