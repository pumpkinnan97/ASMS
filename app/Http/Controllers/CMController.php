<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CMInfo;
use App\Http\Requests;
use App\GRInfo;
use App\COInfo;
use Illuminate\Support\Facades\DB;

class CMController extends Controller
{
    public function show(Request $request,$course_code){
        $cm=CMInfo::where('course_code',$course_code)->get();
        $gr=GRInfo::all();
        $co=COInfo::where('course_code',$course_code)->get();
        $obj_count=DB::select("select count(1) as COUNT from co_infos WHERE course_code=?",[$course_code]);
        $count=$obj_count[0]->COUNT;
        return view('CM.view',["CMs"=>$cm,"GRs"=>$gr,"COs"=>$co,"count"=>$count,"course_code"=>$course_code]);
    }
    public function addCM(Request $request,$course_code){
        $CM=new CMInfo();
        $CM->cm_code=$course_code.'_'.$request->cm_code;
        $CM->course_code=$course_code;
        $CM->name=$request->name;
        $CM->EN_name=$request->EN_name;
        $CM->description=$request->description;
        $CM->english_description=$request->english_description;
        $CM->save();
        $CO_obj_count=DB::select("select count(1) as COUNT from co_infos WHERE course_code=?",[$course_code]);
        $CO_count=$CO_obj_count[0]->COUNT;
        $arr=get_object_vars($request);
        for($i=1;$i<=$CO_count;$i++) {
            if($request->$i!="") {
                DB::insert("insert into cm_cos (cm_code,co_code) VALUES (?,?)", [$CM->cm_code, "CO$i"]);
            }
        }
        if($request->CM_GR1!=""){
            DB::insert("INSERT INTO cm_gr (cm_code,gr_name) VALUES (?,?)",[$CM->cm_code,$request->CM_GR1]);
        }
        if($request->CM_GR2!=""){
            DB::insert("INSERT INTO cm_gr (cm_code,gr_name) VALUES (?,?)",[$CM->cm_code,$request->CM_GR2]);
        }
        if($request->CM_GR3!=""){
            DB::insert("INSERT INTO cm_gr (cm_code,gr_name) VALUES (?,?)",[$CM->cm_code,$request->CM_GR3]);
        }
        if($request->CM_GR4!=""){
            DB::insert("INSERT INTO cm_gr (cm_code,gr_name) VALUES (?,?)",[$CM->cm_code,$request->CM_GR4]);
        }
        return "SAVE SUCCEED!";
    }
}
