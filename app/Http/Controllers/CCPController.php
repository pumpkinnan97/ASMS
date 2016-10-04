<?php

namespace App\Http\Controllers;

use App\CourseInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\COInfo;
// use App\Task;
use App\Repositories\CCPRepository;
use App\CCPInfo;
use Illuminate\Support\Facades\DB;

class CCPController extends Controller
{
    /**
     * The CCP repository instance.
     *
     */
     protected $CCPRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct(CCPRepository $CCPRes)
     {
         $this->CCPRepository = $CCPRes;
     }

    /**
     * Display a list of all of CCPs.
     *
     * @param  Request  $request
     * @return Response
     */
    // public function index(Request $request)
    // public function getGRs(Request $request, $id)
    public function getCCPs(Request $request, $course_code)
    {
//        dd($this->CCPRepository->forTree($course_code));
        return view('CCPs.CCPs', [
            "CCPs" => $this->CCPRepository->forTree($course_code),
            "course_code" => $course_code,
        ]);
    }

    /**
     * Display add page below CCPs.
     *
     * @param  Request  $request
     * @return Response
     */
    public function addCCP(Request $request, $parent_ccp_id)
    {
        $CCPinfo = CCPInfo::find($parent_ccp_id);
        $COs=COInfo::where('course_code',$CCPinfo->course_code)->get();
        $GRs=DB::select("SELECT * FROM gr_courses WHERE course_code =?",[$CCPinfo->course_code]);
        $GRcount=DB::select("SELECT COUNT(1) AS GRCOUNT FROM gr_courses WHERE course_code =?",[$CCPinfo->course_code]);
        $COcount=DB::select("SELECT count(1) AS COCOUNT FROM co_infos WHERE course_code =?",[$CCPinfo->course_code]);
        return view('CCPs.add', [
            "COs"=>$COs,
            "GRs"=>$GRs,
            "GRcount"=>$GRcount[0]->GRCOUNT,
            "COcount"=>$COcount[0]->COCOUNT,
            "ccp_code" => $CCPinfo->ccp_code,
            "course_code" => $CCPinfo->course_code,
            "parent_ccp_id" => $parent_ccp_id,
        ]);
    }

    /**
     * Display a ccp information for edit
     *
     * @return Response
     */
    public function editCCP(Request $request)
    {
        return view('CCPs.editCCP', [
            "CCP" => CCPInfo::find($request->id),
        ]);
    }

    /**
     * Create a new CCPNode.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request, $ccp_code)
    {
        static $arr=array();
        static $GRarr=array();
        $status=false;
        $GR_status=false;
        $ParentCCPinfo = CCPInfo::find($request->parent_ccp_id);
        if ($ParentCCPinfo->is_leaf_ccp == 1) {
            $ParentCCPinfo->is_leaf_ccp = 0;
            $ParentCCPinfo->save();
        }

        $newCCPCode = "";
        $counter = CCPinfo::where('ccp_code', $ccp_code."_%")->count() + 1;
        while(true) {
            $newCCPCode =  $request->ccp_code."_".$counter;
            if(CCPInfo::where('ccp_code', $newCCPCode)->count() != 0)
            {
                $counter++;
            } else {
                break;
            }
        }

        $CCPinfo = new CCPInfo();

        $strs = explode("_ccp", $request->ccp_code);
        $CCPinfo->ccp_code = $newCCPCode;
        $CCPinfo->level = $ParentCCPinfo->level + 1;
        $CCPinfo->course_code = $strs[0];
        $CCPinfo->is_leaf_ccp = $request->is_leaf_ccp;
        $CCPinfo->name = $request->name;
        $CCPinfo->description = $request->description;
        $CCPinfo->expected_score = $request->expected_score;
        $CCPinfo->standard_score = $request->standard_score;
        /***************************处理权重部分*/
            if($request->CO1!="" && $request->CO_weight1!=""){
                $ccp_co_rest_weight_arr=DB::select("SELECT * FROM co_infos WHERE co_code =?",[$request->CO1]);
                $ccp_co_rest_weight=$ccp_co_rest_weight_arr[0]->ccp_CO_rest_as_weight-$request->CO_weight1;
                if($ccp_co_rest_weight>=0){;
                    DB::update("UPDATE co_infos SET ccp_CO_rest_as_weight=? where co_code=?",[$ccp_co_rest_weight,$request->CO1]);
                    $arr[]=[$request->CO1 => $request->CO_weight1];
                }
                else{
                    die("权重错误！！！");
                }
                $status=true;
        }
        if($request->CO2!="" && $request->CO_weight2!=""){
            $ccp_co_rest_weight_arr=DB::select("SELECT * FROM co_infos WHERE co_code =?",[$request->CO2]);
            $ccp_co_rest_weight=$ccp_co_rest_weight_arr[0]->ccp_CO_rest_as_weight-$request->CO_weight2;
            if($ccp_co_rest_weight>=0){
                DB::update("UPDATE co_infos SET ccp_CO_rest_as_weight=? where co_code=?",[$ccp_co_rest_weight,$request->CO2]);
                $arr[]=[$request->CO2 => $request->CO_weight2];
            }
            else{
                die("权重错误！！！");
            }
            $status=true;
        }
        if($request->CO3!="" && $request->CO_weight3!=""){
            $ccp_co_rest_weight_arr=DB::select("SELECT * FROM co_infos WHERE co_code =?",[$request->CO3]);
            $ccp_co_rest_weight=$ccp_co_rest_weight_arr[0]->ccp_CO_rest_as_weight-$request->CO_weight3;
            if($ccp_co_rest_weight>=0){
                DB::update("UPDATE co_infos SET ccp_CO_rest_as_weight=? where co_code=?",[$ccp_co_rest_weight,$request->CO3]);
                $arr[]=[$request->CO3 => $request->CO_weight3];
            }
            else{
                die("权重错误！！！");
            }
            $status=true;
        }
        if($request->CO4!="" && $request->CO_weight4!=""){
            $ccp_co_rest_weight_arr=DB::select("SELECT * FROM co_infos WHERE co_code =?",[$request->CO4]);
            $ccp_co_rest_weight=$ccp_co_rest_weight_arr[0]->ccp_CO_rest_as_weight-$request->CO_weight4;
            if($ccp_co_rest_weight>=0){
                DB::update("UPDATE co_infos SET ccp_CO_rest_as_weight=? where co_code=?",[$ccp_co_rest_weight,$request->CO4]);
                $arr[]=[$request->CO4 => $request->CO_weight4];
            }
            else{
                die("权重错误！！！");
            }
            $status=true;

        }
        if($request->GR1!="" && $request->GR_weight1!=""){
            $ccp_gr_rest_weight_arr=DB::select("SELECT * FROM gr_infos WHERE gr_code =?",[$request->GR1]);
            $ccp_gr_rest_weight=$ccp_gr_rest_weight_arr[0]->ccp_GR_rest_as_weight-$request->GR_weight1;
            if($ccp_gr_rest_weight>=0){
                DB::update("UPDATE gr_infos SET ccp_GR_rest_as_weight=? where gr_code=?",[$ccp_gr_rest_weight,$request->GR1]);
                $GRarr[]=[$request->GR1 => $request->GR_weight1];
            }
            else{
                die("权重错误！！！");
            }
            $GR_status=true;

        }
        if($request->GR4!="" && $request->GR_weight4!=""){
            $ccp_gr_rest_weight_arr=DB::select("SELECT * FROM gr_infos WHERE gr_code =?",[$request->GR4]);
            $ccp_gr_rest_weight=$ccp_gr_rest_weight_arr[0]->ccp_GR_rest_as_weight-$request->GR_weight4;
            if($ccp_gr_rest_weight>=0){
                DB::update("UPDATE gr_infos SET ccp_GR_rest_as_weight=? where gr_code=?",[$ccp_gr_rest_weight,$request->GR4]);
                $GRarr[]=[$request->GR4 => $request->GR_weight4];
            }
            else{
                die("权重错误！！！");
            }
            $GR_status=true;

        }
        if($request->GR2!="" && $request->GR_weight2!=""){
            $ccp_gr_rest_weight_arr=DB::select("SELECT * FROM gr_infos WHERE gr_code =?",[$request->GR2]);
            $ccp_gr_rest_weight=$ccp_gr_rest_weight_arr[0]->ccp_GR_rest_as_weight-$request->GR_weight2;
            if($ccp_gr_rest_weight>=0){
                DB::update("UPDATE gr_infos SET ccp_GR_rest_as_weight=? where gr_code=?",[$ccp_gr_rest_weight,$request->GR2]);
                $GRarr[]=[$request->GR2 => $request->GR_weight2];
            }
            else{
                die("权重错误！！！");
            }
            $GR_status=true;

        }
        if($request->GR3!="" && $request->GR_weight3!=""){
            $ccp_gr_rest_weight_arr=DB::select("SELECT * FROM gr_infos WHERE gr_code =?",[$request->GR3]);
            $ccp_gr_rest_weight=$ccp_gr_rest_weight_arr[0]->ccp_GR_rest_as_weight-$request->GR_weight3;
            if($ccp_gr_rest_weight>=0){
                DB::update("UPDATE gr_infos SET ccp_GR_rest_as_weight=? where gr_code=?",[$ccp_gr_rest_weight,$request->GR3]);
                $GRarr[]=[$request->GR3 => $request->GR_weight3];
            }
            else{
                die("权重错误！！！");
            }
            $GR_status=true;

        }


        if($status==true && $GR_status==true) {
            $CCPinfo->ccp_CO_as_weight=json_encode($arr);
            $CCPinfo->ccp_GR_as_weight=json_encode($GRarr);
            $CCPinfo->save();
            return json_encode(array('status' => 'true'));
        }
    }

    /**
     * update a new CCPNode.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $CCPinfo = CCPInfo::find($id);

        $CCPinfo->name = $request->name;
        $CCPinfo->description = $request->description;
        $CCPinfo->standard_score = $request->standard_score;
        $CCPinfo->expected_score = $request->expected_score;

        $CCPinfo->save();

        return json_encode(array('status' => 'true'));
    }

    /**
     * Destroy the CCP
     *
     * @return Response
     */
    public function destroyCCP(Request $request, $id)
    {
        $ccp = CCPInfo::find($id);
        //判断是否为根节点
        if ($ccp->level == 0)
        {
            CCPInfo::destroy($id);
            return json_encode(array('status' => true));
        }
        //判断是否为叶子节点
        if ($ccp->is_leaf_ccp == 1)
        {
            /********************还原权重***********************/
            $back_CO=DB::select("SELECT * FROM ccp_infos WHERE id =?",[$id]);
            $back_GR=DB::select("SELECT * FROM ccp_infos WHERE id =?",[$id]);
            $back_CO_arr=json_decode($back_CO[0]->ccp_CO_as_weight,1);
            $back_GR_arr=json_decode($back_GR[0]->ccp_GR_as_weight,1);
            foreach($back_CO_arr as $back_co_arr){
                foreach ($back_co_arr as $CO_code => $weight){
                    $co=DB::select("SELECT * FROM co_infos WHERE co_code =?",[$CO_code]);
                    $rest_co_weight=$co[0]->ccp_CO_rest_as_weight;
                    DB::update("UPDATE co_infos SET ccp_CO_rest_as_weight=? WHERE co_code=?",[$rest_co_weight+$weight,$CO_code]);
                }
        }
            foreach ($back_GR_arr as $back_gr_arr) {
                foreach ($back_gr_arr as $gr_code => $gr_weight) {
                    $gr = DB::select("SELECT * FROM gr_infos WHERE gr_code =?", [$gr_code]);
                    $rest_gr_weight = $gr[0]->ccp_GR_rest_as_weight;
                    DB::update("UPDATE gr_infos SET ccp_GR_rest_as_weight =? WHERE gr_code=?", [$gr_weight + $rest_gr_weight, $gr_code]);
                }
            }
            CCPInfo::destroy($id);

            //判断父节点是否还有子节点
            $strs_arr = explode("_", $ccp->ccp_code);
            $str = "";
            for ($i = 0; $i < count($strs_arr) - 1; $i++)
            {
                $str .= $strs_arr[$i]."_";
            }

            if (CCPInfo::where('ccp_code', 'like', $str.'%')->count() == 0){
                $changedParent = CCPInfo::where('ccp_code', substr($str, 0, -1))->get()[0];
                $changedParent->is_leaf_ccp = 1;
                $changedParent->save();
            }
            return json_encode(array('status' => true));
        } else {
            return json_encode(array('status' => false,
                                     'info'   => '请删除子项后再删除本项'));
        }


    }

    /**
     * show the page edit RootCCP
     * $course_code
     * @return Response
     */
    public function addRootCCP(Request $request, $course_code)
    {

        return view("CCPs.addRootCCP", [
            "course_code" => $course_code,
            "course" => CourseInfo::where('course_code', $course_code)->get()[0],
            "ccp_code" => $course_code."_ccp",
        ]);
    }

    /**
     * Create the RootCCP
     * $ccp_code
     * @return Response
     */
    public function createRootCCP(Request $request, $ccp_code)
    {
        $CCPinfo = new CCPInfo();

        $strs = explode("_ccp", $ccp_code);
        $CCPinfo->ccp_code = $ccp_code;
        $CCPinfo->level = 0;
        $CCPinfo->course_code = $strs[0];
        $CCPinfo->is_leaf_ccp = $request->is_leaf_ccp;
        $CCPinfo->name = $request->name;
        $CCPinfo->description = $request->description;
        $CCPinfo->expected_score = $request->expected_score;
        $CCPinfo->standard_score = $request->standard_score;

        $CCPinfo->save();

        return json_encode(array('status' => true));
    }
    
    /**
     * Get the CCPs of all the students
     * @param $course_code
     * @return Response
     */
    public function getStudentsCCPs(Request $request, $course_code)
    {
        $leafCCPsName = $this->CCPRepository->leafCCPforCourse($course_code);
//        dd($leafCCPsName);
        return view('CCPs.studentsCCPs', [
            'leafCCPsName' => $leafCCPsName,
            'course_code' => $course_code
        ]);
    }

    /**
     * Get the CCPs of all the students
     * @param $course_code
     * @return Response
     */
    public function getUpLoadCCPTemplate(Request $request, $course_code)
    {
        return view('CCPs.uploadCCPTemplate', [
            'course_code' => $course_code,
        ]);
    }
    
}
