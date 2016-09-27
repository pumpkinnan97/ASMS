<?php

namespace App\Http\Controllers;

use App\CourseInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


// use App\Task;
use App\Repositories\CCPRepository;
use App\CCPInfo;

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
        return view('CCPs.add', [
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

        $strs = explode("_", $request->ccp_code);
        $CCPinfo->ccp_code = $newCCPCode;
        $CCPinfo->level = $ParentCCPinfo->level + 1;
        $CCPinfo->course_code = $strs[0];
        $CCPinfo->is_leaf_ccp = $request->is_leaf_ccp;
        $CCPinfo->name = $request->name;
        $CCPinfo->description = $request->description;
        $CCPinfo->expected_score = $request->expected_score;
        $CCPinfo->standard_score = $request->standard_score;

        $CCPinfo->save();

        return json_encode(array('status' => $ParentCCPinfo->is_leaf_ccp));
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

        $strs = explode("_", $ccp_code);
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
