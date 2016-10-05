<?php

namespace App\Http\Controllers;

use App\CCPToGRASWeightCriteria;
use App\CourseInfo;
use App\Repositories\CCPRepository;
use DaveJamesMiller\Breadcrumbs\View;
use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use App\Task;
use App\Repositories\GRRepository;
use App\GRInfo;
use App\ALLGR;
use App\GRCourses;
use Illuminate\Support\Facades\DB;

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
            'GRs1' => $this->GRRespository->forGRAtLevel(),
            'GRDetails' => $this->GRRespository->forGRsRelations(),
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
            'GRs' => $this->GRRespository->forGRs(),
        ]);
    }

    public function updateGRs(Request $request,$gr_code)
    {
        preg_match_all('/gr_\d?\d/i',$gr_code,$allgr_code);
        $ALLGR=DB::select("SELECT * FROM allgr_infos WHERE ALLGR_code=?",[$allgr_code[0][0]]);
        $back_ALLGR=DB::select("SELECT * FROM gr_infos WHERE gr_code=?",[$gr_code]);
        $back_GR_weight=$ALLGR[0]->gr_ALLGR_rest_as_weight+$back_ALLGR[0]->gr_ALLGR_weight;
        DB::update("UPDATE allgr_infos SET gr_ALLGR_rest_as_weight=? WHERE ALLGR_code=?", [$back_GR_weight, $allgr_code[0][0]]);

        $ALLGR_SECOND=DB::select("SELECT * FROM allgr_infos WHERE ALLGR_code=?",[$allgr_code[0][0]]);
        $rest=$ALLGR_SECOND[0]->gr_ALLGR_rest_as_weight-$request->gr_ALLGR_weight;
        if($rest>=0) {
            DB::update("UPDATE allgr_infos set gr_ALLGR_rest_as_weight=? where ALLGR_code=?",[$rest,$allgr_code[0][0]]);
            DB::update("UPDATE gr_infos SET name = ? ,standart_description = ?,ise_description = ?,gr_ALLGR_weight = ? where gr_code =?", [$request
                ->name, $request->standart_description, $request->ise_description, $request->gr_ALLGR_weight, $gr_code]);
        }
        else{
            die("对应父项GR权重已不足！");
        }
    }
    public function deleteGRCourse(Request $request,$gr_code){
        DB::delete("DELETE FROM gr_courses WHERE gr_code=?",[$gr_code]);
    }
    public function addGRs(Request $request){
        $ALLGRs=ALLGR::all();
        $GRs=GRInfo::all();
        return view('GRs.addGRs',["ALLGRs"=>$ALLGRs,"GRs"=>$GRs]);
    }
    public function add(Request $request){
        $new_GR=new GRInfo();
        $new_GR->gr_code=$request->gr_code;
        $new_GR->name=$request->name;
        $new_GR->standart_description=$request->standart_description;
        $new_GR->ise_description=$request->ise_description;
        $new_GR->gr_ALLGR_weight=$request->gr_ALLGR_weight;
        $new_GR->CO_GR_rest_as_weight=1.00;
        $new_GR->ccp_GR_rest_as_weight=1.00;
        preg_match_all('/gr_\d?\d/i',$request->gr_code,$allgr_code);
        $ALLGR=DB::select("SELECT * FROM allgr_infos WHERE ALLGR_code=?",[$allgr_code[0][0]]);
        $rest_GR_weight=$ALLGR[0]->gr_ALLGR_rest_as_weight-$request->gr_ALLGR_weight;
        if($rest_GR_weight <= 0){
            return "父项GR权重已不足";
        }
        else {
            DB::update("UPDATE allgr_infos SET gr_ALLGR_rest_as_weight=? WHERE ALLGR_code=?", [$rest_GR_weight, $allgr_code[0][0]]);
            $new_GR->save();
            return json_encode(array('status' => 'true'));
        }
}
    public function deleteGR(Request $request, $gr_code)
    {
        $GR=GRInfo::where("gr_code",$gr_code)->get();
        preg_match_all('/gr_\d?\d/i',$gr_code,$allgr_code);
        $ALLGR=DB::select("SELECT * FROM allgr_infos WHERE ALLGR_code=?",[$allgr_code[0][0]]);
        $back_weight=$ALLGR[0]->gr_ALLGR_rest_as_weight+$GR[0]->gr_ALLGR_weight;
        DB::update("UPDATE allgr_infos SET gr_ALLGR_rest_as_weight = ? WHERE ALLGR_code=?",[$back_weight,$allgr_code[0][0]]);
        DB::delete("DELETE FROM gr_courses WHERE gr_code=?",[$gr_code]);
        DB::delete("DELETE FROM gr_infos WHERE gr_code=?",[$gr_code]);
        return json_encode(array('status' => 'true'));
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

    public function addGRCourses(Request $request){
        $GRs=GRInfo::all();
        $courses=CourseInfo::all();
        return view('GRs.addGRCourses',["GRs"=>$GRs,"courses"=>$courses]);
    }
    public function addGRCourse(Request $request){
        $gr_code=GRInfo::where("name",$request->GR_name)->first();
        $course_code=CourseInfo::where("name",$request->Course_name)->first();
        DB::insert("INSERT INTO gr_courses(gr_code,course_code) VALUES (?,?)",[$gr_code->gr_code,$course_code->course_code]);
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
    public function saveGRs(Request $request,$gr_code){
       // $GR=GRInfo::find($gr_code);
       // $GR->name=$request->name;
        var_dump($request);
      //  $GR->standart_description=$request->standart_description;
       // $GR->ise_description=$request->ise_description;
      //  $GR->gr_ALLGR_weight=$request->gr_ALLGR_as_weight;
      // $GR->save();
    }
}
