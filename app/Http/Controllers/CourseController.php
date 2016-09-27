<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CourseInfo;
class CourseController extends Controller
{
    public function show(){
        return view('course.course');
    }
    public function add(Request $request){
        $course=new CourseInfo();
        $today=
        $course->course_code=$request->term.$request->course_code;
        $course->name=$request->name;
        $course->english_name=$request->english_name;
        $course->total_hours=$request->total_hours;
        $course->credit=$request->credit;
        $course->type=$request->type;
        $course->major=$request->major;
        $course->course_group=$request->course_group;
        $course->prerequisite_course=$request->prerequisite_course;
        $course->english_description=$request->english_description;
        $course->description=$request->description;
        $course->author=$request->author;
        $course->test_way=$request->test_way;
        $course->edit_date=date('Y-m-d',time());
        $course->cd_name=$request->cd_name;
        $course->save();
    }
}
