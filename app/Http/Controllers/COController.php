<?php

namespace App\Http\Controllers;

use App\CCPToCOASWeightCriteria;
use App\CCPToGRASWeightCriteria;
use App\Repositories\CCPRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\COInfo;
use App\Repositories\CORepository;
use App\CourseInfo;
use App\StudentCCP;
use App\Repositories\GRRepository;
use Mockery\CountValidator\Exception;

class COController extends Controller
{
    /**
     * The GR repository instance.
     *
     * @var GRRepository
     */
    protected $GRRepository;
    /**
     * 课程目标的资源库的实例。
     *
     * @var CORepository
     */
    protected $CORepository;

    /**
     * 课程考查点目标的资源库的实例。
     *
     * @var CCPRepository
     */
    protected $CCPRepository;

    protected $CourseRepository;

    /**
     * Create a new controller instance.
     *
     * @param  CORepository  $COs
     */
     public function __construct(CORepository $COs, CCPRepository $CCPs,GRRepository $GRs)
     {
         $this->CORepository = $COs;
         $this->CCPRepository = $CCPs;
         $this->GRRepository = $GRs;
     }

    /**
     * Display a list of all of the course_code's CO.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getCOs(Request $request, $course_code)
    {
//        dd($this->CORepository->forCourse($course_code));
        return view('COs.COs', [
            "COs" => $this->CORepository->forCourse($course_code),
            "course_code" => $course_code,
        ]);
    }

    /**
     * Display COs relate to this course
     *
     * @return Response
     */
    public function editCOs(Request $request, $course_code)
    {
        return view('COs.editCOs', [
            "COs" => $this->CORepository->forCourse($course_code),
            "course_code" => $course_code,
            "new_CO_id" => $this->CORepository->nextCOCode($course_code),
        ]);
    }
    /**
     * Create a new CO.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request, $course_code)
    {
        $COinfo = new COInfo();

        $COinfo->course_code = $course_code;
        $COinfo->co_code = '2014-2015-1'.$course_code.'_'.$request->name;
        $COinfo->name = $request->name;
        $COinfo->description = $request->description;
        $COinfo->english_description = $request->english_description;
        $COinfo->expected_scale = $request->expected_scale;
        $COinfo->achivement_scale=$request->achivement_scale;
        $COinfo->CO_GR_as_weight = $request->CO_GR_as_weight;

        $COinfo->save();

        return json_encode(array('status' => 'true'));
    }


    /**
     * update a CO.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request, $co_id)
    {
        COInfo::find($co_id)
              ->update([$request->data_type => $request->data]);

        return json_encode(array('status' => 'true'));
    }


    /**
     * Destroy the given co.
     *
     * @param  Request  $request
     * @param  $co_code
     * @return Response
     */
    public function destroy(Request $request, $co_id)
    {
        COInfo::destroy($co_id);

        //解析co_code获取course_code和number
//        $co_strs = explode("_", $co_code);
//        $course_code = $co_strs[0];
//        $co_num = $co_strs[2];
//        $total_co_num = $this->CORepository->COsNumber($course_code);
//        $co = COInfo::where('co_code', $course_code."_co_".($co_num + 1))->delete();

//        $counter = 0;
//        if ($total_co_num != $co_num){
//            for ($i = $co_num + 1; $i <= $total_co_num + 1; $i++)
//            {
//                $co = COInfo::where('co_code', $course_code."_co_".$i)->get();

//                $new_co = new COInfo();
//                $new_co->co_code = $course_code."_co_".($i - 1);
//                $new_co->course_code = $course_code;
//                $new_co->name = $co->name;
//                $new_co->description = $co->description;
//                $new_co->english_description = $co->english_description;
//                $new_co->expected_achievement_scale = $co->expected_achievement_scale;
//                $new_co->co_as_weight = $co->co_as_weight;
//                $new_co->save();

//                COInfo::where('co_code', $course_code."_co_".$i)->delete();
//
//                $counter++;
//            }
//        }

        return json_encode(array('status' => 'true'));
    }

    /**
     * Display the a list of the course_code's CO and the CCP belong to it.
     *
     * @param  Request  $request
     * @param  $course_code
     * @return Response
     */
    public function getCOsAndCCPs(Request $request, $course_code)
    {
        return view('COs.COsAndCCPs', [
            'COsAndCCPs' => $this->CORepository->forCourse($course_code),
        ]);
    }

    /**
     * Display the edit page of CO and the CCPs belong to it.
     *
     * @param  Request  $request
     * @param  $co_id
     * @return Response
     */
    public function editCOAndCCPs(Request $request, $co_id)
    {
        $COinfo = COInfo::find($co_id);
        $CCPs = $this->CCPRepository->forTree($COinfo->course_code);
        $CCPToCOASWeightCriteria = CCPToCOASWeightCriteria::where('co_code',$COinfo->co_code)->where('course_code',$COinfo->course_code)->get();
        foreach ($CCPToCOASWeightCriteria as $value)
            $criterion = $value['criterion'];
        if(!empty($criterion)){
            $criterion = unserialize($criterion);
            foreach ($CCPs as $key => $value){
                $CCPs[$key]['value'] = 0;
                foreach ($criterion as $subValue){
                    if($value['id'] == $subValue['ccp_id']){
                        $CCPs[$key]['value'] = 1;
                        break;
                    }
                }
            }
        }else{
            foreach ($CCPs as $key => $value){
                $CCPs[$key]['value'] = 0;
            }
        }

        return view('COs.editCOAndCCPs', [
            'CO' => $COinfo,
            'CCPs' => $CCPs,
            'co_id' => $co_id,
        ]);
    }

    public function addCOAndCCPS(Request $request, $co_id){
        $COinfo = COInfo::find($co_id);
//        $CCPToCOASWeightCriteria = CCPToCOASWeightCriteria::firstOrNew(array('co_code' => '$COinfo->co_code','course_code'=>$COinfo->course_code));
        $jud = CCPToCOASWeightCriteria::where('co_code',$COinfo->co_code)->where('course_code',$COinfo->course_code)->get();
        foreach ($jud as $value)
            $tempJud = $value['criterion'];
        $CCPToCOASWeightCriteria = new CCPToCOASWeightCriteria();
        $CCPToCOASWeightCriteria->co_code = $COinfo->co_code;
        $CCPToCOASWeightCriteria->course_code = $COinfo->course_code;
        // json格式化
        $CCPToCOASWeightCriteria->criterion = serialize($request->selectedCCP);
        if(empty($tempJud)){
            $CCPToCOASWeightCriteria->save();
        }else{
            CCPToCOASWeightCriteria::where('co_code',$COinfo->co_code)->where('course_code',$COinfo->course_code)->update(array('co_code'=>$COinfo->co_code,'course_code'=>$COinfo->course_code,'criterion'=>serialize($request->selectedCCP)));
        }
        return json_encode(array('status' => 'true'));
    }

    // 权重计算
    public function getStudentsCOGR(Request $request, $course_code){
        $courseInfo = CourseInfo::where('course_code',$course_code)->get();
        foreach ($courseInfo as $value)
            $tempName = $value['name'];
        if(empty($tempName)){
            return json_encode(array('status' => 'false'));
        }else{
            // COs
            $COs = $this->CORepository->forCourse($course_code);
            // GRs
            $GRs = $this->GRRepository->forCourse($course_code);
            // CCPs
            $CCPs = $this->CCPRepository->forTree($course_code);
            // 计算CO达成度
            foreach ($COs as $COKey => $COValue){
                // 获取CO_CCP
                $CO_CCPs = CCPToCOASWeightCriteria::where('co_code',$COValue['co_code'])->where('course_code',$course_code)->get();
                foreach ($CO_CCPs as $COCCPvalue)
                    $criterion = $COCCPvalue['criterion'];
                if(!empty($criterion)&&count($criterion)==1){
                    $criterion = unserialize($criterion);
                    // 期望达成度 expected_score_percent
                    $COs[$COKey]['expected_score_percent'] = 0;
                    $COTempExpe = 0;
                    $COTempStand = 0;
                    foreach ($CCPs as $CCPkey => $CCPvalue){
                        foreach ($criterion as $subValue){
                            if($CCPvalue['id'] == $subValue['ccp_id']){
                                $COTempExpe += $CCPvalue['expected_score'];
                                $COTempStand += $CCPvalue['standard_score'];
//                                $COs[$COKey]['expected_score_percent'] += $CCPvalue['expected_score'] / $CCPvalue['standard_score'] * $subValue['weight'];
                                break;
                            }
                        }
                    }
                    $COs[$COKey]['expected_score_percent'] = $COTempExpe / $COTempStand;
                    // 实际达成度 real_score_percent
                    $COs[$COKey]['real_score_percent'] = 0;
                    $COTempExpe = 0;
                    $COTempStand = 0;
                    // 获取StudentCCP
                    foreach ($CCPs as $CCPkey => $CCPvalue){
                        foreach ($criterion as $subValue){
                            if($CCPvalue['id'] == $subValue['ccp_id']){
                                $StudentCCP = StudentCCP::where('ccp_code',$CCPvalue['id'])->get();
                                $COTempStand += $CCPvalue['standard_score'];
                                foreach ($StudentCCP as $stdCCPValue){
                                    $COTempExpe += $stdCCPValue['score'] / count($StudentCCP);
//                                    $COs[$COKey]['real_score_percent'] += $stdCCPValue['score'] / $CCPvalue['standard_score'] * $subValue['weight'] / count($StudentCCP);
                                }
                                break;
                            }
                        }
                    }
                    $COs[$COKey]['real_score_percent'] = $COTempExpe / $COTempStand;
                }else{
                    continue;
                }
            }
            // 计算GR达成度
            foreach ($GRs as $GRKey => $GRValue){
                // 获取CO_CCP
                $GR_CCPs = CCPToGRASWeightCriteria::where('gr_code',$GRValue['gr_code'])->where('course_code',$course_code)->get();
                foreach ($GR_CCPs as $GRCCPvalue)
                    $criterion = $GRCCPvalue['criterion'];
                if(!empty($criterion)&&count($criterion)==1){
                    $criterion = unserialize($criterion);
                    // 期望达成度 expected_score_percent
                    $GRs[$GRKey]['expected_score_percent'] = 0;
                    $GRTempExpe = 0;
                    $GRTempStand = 0;
                    foreach ($CCPs as $CCPkey => $CCPvalue){
                        foreach ($criterion as $subValue){
                            if($CCPvalue['id'] == $subValue['ccp_id']){
                                $GRTempExpe += $CCPvalue['expected_score'];
                                $GRTempStand += $CCPvalue['standard_score'];
//                                $GRs[$GRKey]['expected_score_percent'] += $CCPvalue['expected_score'] / $CCPvalue['standard_score'] * $subValue['weight'];
                                break;
                            }
                        }
                    }
                    $GRs[$GRKey]['expected_score_percent'] = $GRTempExpe / $GRTempStand;
                    // 实际达成度 real_score_percent
                    $GRs[$GRKey]['real_score_percent'] = 0;
                    $GRTempExpe = 0;
                    $GRTempStand = 0;
                    // 获取StudentCCP
                    foreach ($CCPs as $CCPkey => $CCPvalue){
                        foreach ($criterion as $subValue){
                            if($CCPvalue['id'] == $subValue['ccp_id']){
                                $StudentCCP = StudentCCP::where('ccp_code',$CCPvalue['id'])->get();
                                $GRTempStand += $CCPvalue['standard_score'];
                                foreach ($StudentCCP as $stdCCPValue){
                                    $GRTempExpe += $stdCCPValue['score'] / count($StudentCCP);
//                                    $GRs[$GRKey]['real_score_percent'] += $stdCCPValue['score'] / $CCPvalue['standard_score'] * $subValue['weight'] / count($StudentCCP);
                                }
                                break;
                            }
                        }
                    }

                    $GRs[$GRKey]['real_score_percent'] = $GRTempExpe / $GRTempStand;

                    $GRs[$GRKey]['expected_score_percent_weight'] = $GRs[$GRKey]['expected_score_percent'] * $GRValue['gr_as_weight'];

                    $GRs[$GRKey]['real_score_percent_weight'] = $GRs[$GRKey]['real_score_percent'] * $GRValue['gr_as_weight'];
                }else{
                    continue;
                }
            }
            return view('COGRs.COGRs', [
                "course_name" => $tempName,
                "COs" => $COs,
                "GRs" => $GRs,
                "course_code" => $course_code,
             ]);
        }
    }


    /**
     * 验证CO的权重是否为1
     * @param Request $request
     * @param $course_code
     */
    public function validateCOWeightSum(Request $request, $course_code){
        return $this->CORepository->forCOWeightSum($course_code) == 1 ? json_encode(array('status' => 'true')) : json_encode(array('status' => 'false'));
    }
}
