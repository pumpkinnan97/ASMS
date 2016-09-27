<?php

namespace App\Repositories;

use App\CourseInfo;
use App\GRInfo;
use App\GRCourses;
/**
 * offer data for GRController's actions
 */
class GRRepository
{
    public function forGRs()
    {
        $resultSet = array();
        $maxLevel = GRInfo::max('level');
        for ($i = 0; $i < $maxLevel; $i++)
        {
            $resultSet[$i] = GRInfo::where('level', $i + 1)->get();
        }
        return empty($resultSet) ? false : $resultSet;
    }

    public function forGRAtLevel($level)
    {
        $resultSet = GRInfo::where('level', $level)->get();
        return empty($resultSet) ? false : $resultSet;
    }

    public function forGRsCourses($gr_code)
    {
        $resultSet = array();

        $GRCourses = GRCourses::where('gr_code', $gr_code)->get();

        $courseCounter = 0;
        foreach ($GRCourses as $course)
        {
            $course_code = explode(",", $course->course_code);
            $resultSet[$courseCounter]['code'] = $course_code[0];
            $resultSet[$courseCounter]['name'] = CourseInfo::where('course_code', $course_code[0])->get()[0]->name;
            $resultSet[$courseCounter]['weight'] = $course->cs_to_gr_as_weight;
            $courseCounter++;
        }

        return $resultSet;
    }

    public function forGRsRelations()
    {
        $level1GRSet = GRInfo::where('level', 1)->get();
        $resultSet = array();

        $counter = 0;
        foreach ($level1GRSet as $level1GR)
        {
            $resultSet[$counter]['level1'] = $level1GR;
            $level2GRSet = GRInfo::where('gr_code', 'REGEXP', $level1GR->gr_code."_")->get();

            $level2GRSetCounter = 0;
            foreach ($level2GRSet as $level2GR)
            {
                $resultSet[$counter]['level2'][$level2GRSetCounter]['gr'] = $level2GR;

                $courseCodes = GRCourses::where('gr_code', $level2GR->gr_code)->get();

                $coursesArr = array();
                $courseCodeCounter = 0;
                foreach ($courseCodes as $courseCode)
                {
                    $course_codes = explode(',', $courseCode->course_code);
                    $courseInfo = CourseInfo::where('course_code', $course_codes[0])->get();
                    $coursesArr[$courseCodeCounter]['name'] = empty($courseInfo[0]->name)? "none" : $courseInfo[0]->name;
                    $coursesArr[$courseCodeCounter]['weight'] = $courseCode->cs_to_gr_as_weight;
                    $courseCodeCounter++;
                }
                $resultSet[$counter]['level2'][$level2GRSetCounter]['courses'] = $coursesArr;

                $level2GRSetCounter++;
            }

            $counter++;
        }

        return empty($resultSet) ? false : $resultSet;
    }

    public function forCourse($course_code)
    {
        $resultSet = array();

        $course_grs = GRCourses::where('course_code', $course_code)->get();

        $course_grsCounter = 0;
        foreach ($course_grs as $course_gr)
        {
            $resultSet[$course_grsCounter] = GRInfo::where('gr_code', $course_gr->gr_code)->get()[0];
            $course_grsCounter++;
        }

        return $resultSet;
    }
}
