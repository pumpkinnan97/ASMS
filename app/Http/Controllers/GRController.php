<?php

namespace App\Http\Controllers;

use App\CCPToGRASWeightCriteria;
use App\Repositories\CCPRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use App\Task;
use App\Repositories\GRRepository;
use App\GRInfo;
use App\GRCourses;

class GRController extends Controller
{
    /**
     * 课程考查点目标的资源库的实例。
     *
     * @var CCPRepository
     */
    protected $CCPRepository;
    /**
     * The GR repository instance.
     *
     * @var GRRepository
     */
    protected $GRRespository;

    /**
     * Create a new controller instance.
     *
     * @param  GRRepository  $Repository
     */
    public function __construct(GRRepository $Repository,CCPRepository $CCPs)
    {
//         $this->middleware('auth');

        $this->GRRespository = $Repository;
        $this->CCPRepository = $CCPs;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getGRs(Request $request)
    {
//        dd($this->GRRespository->forGRsRelations(2));
        return view('GRs.GRs', [
            'GRs1' => $this->GRRespository->forGRAtLevel(1),
            'GRDetails' => $this->GRRespository->forGRsRelations(2),
        ]);
    }

    /**
     * Display all the GRs below GR
     *
     * @return Response
     */
    public function editGRs()
    {
        return view('GRs.editGRs',[
            'GRs' => $this->GRRespository->forGRAtLevel(1),
        ]);
    }

    public function update()
    {

    }
    

    /**
     * Display current GR's relationship with courses
     *
     * @return Response
     */
    public function editGRsCourses(Request $request, $gr_code)
    {
//        dd($this->GRRespository->forGRsCourses($gr_code));
        return view('GRs.editGRsCourses', [
            'courses' => $this->GRRespository->forGRsCourses($gr_code),
            'gr_code' => $gr_code,
        ]);
    }

    public function updateGRsCourse(Request $request, $gr_code, $course_code)
    {
        $gr_course = GRCourses::where('gr_code', $gr_code)
                              ->where('course_code', $course_code)
                              ->update([$request->data_type => $request->data])
                              ->save();

        return json_encode(array('status' => 'true'));
    }



    /**
     * Display the a list of the course_code's GRs and CCPs belong to it.
     *
     * @param  Request  $request
     * @param  $course_code
     * @return Response
     */
    public function getGRsAndCCPs(Request $request, $course_code)
    {
//        dd($this->GRRespository->forCourse($course_code));
        return view('GRs.GRsAndCCPs', [
            'GRsAndCCPs' => $this->GRRespository->forCourse($course_code),
            'course_code' => $course_code,
        ]);
    }

    /**
     * Display the edit page of GR and the CCPs belong to it.
     *
     * @param  Request  $request
     * @param  $co_id
     * @return Response
     */
    public function editGRAndCCPs(Request $request,$gr_code, $course_code)
    {
        $CCPs = $this->CCPRepository->forTree($course_code);
        $CCPToGRASWeightCriteria = CCPToGRASWeightCriteria::where('gr_code',$gr_code)->where('course_code',$course_code)->get();
        foreach ($CCPToGRASWeightCriteria as $value)
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

        return view('GRs.editGRAndCCPs', [
            'CCPs' => $CCPs,
            'gr_code' => $gr_code,
            'course_code' => $course_code,
        ]);
    }
    
    public function addGRAndCCPS(Request $request, $gr_code, $course_code){
        $jud = CCPToGRASWeightCriteria::where('gr_code',$gr_code)->where('course_code',$course_code)->get();
        foreach ($jud as $value)
            $tempJud = $value['criterion'];
        $CCPToGRASWeightCriteria = new CCPToGRASWeightCriteria();
        $CCPToGRASWeightCriteria->gr_code = $gr_code;
        $CCPToGRASWeightCriteria->course_code = $course_code;
        // json格式化
        $CCPToGRASWeightCriteria->criterion = serialize($request->selectedCCP);
        if(empty($tempJud)){
            $CCPToGRASWeightCriteria->save();
        }else{
            CCPToGRASWeightCriteria::where('gr_code',$gr_code)->where('course_code',$course_code)->update(array('gr_code'=>$gr_code,'course_code'=>$course_code,'criterion'=>serialize($request->selectedCCP)));
        }
        return json_encode(array('status' => 'true'));
    }
}
