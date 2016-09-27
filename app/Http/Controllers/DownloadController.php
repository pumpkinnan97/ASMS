<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Maatwebsite\Excel\Facades\Excel;

use App\Repositories\CCPRepository;

class DownloadController extends Controller
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
     * return a ccp_infos Excel
     *
     * @param  Request  $request
     * @param  String  $course_code
     * @return file
     */
    public function downloadCCPs(Request $request, $course_code)
    {

    }

    /**
     * return a gr_infos Excel
     *
     * @param  Request  $request
     * @param  String  $course_code
     * @return file
     */
    public function downloadGRs(Request $request, $course_code)
    {

    }

    /**
     * return a co_infos Excel
     *
     * @param  Request  $request
     * @param  String  $course_code
     * @return file
     */
    public function downloadCOs(Request $request, $course_code)
    {

    }

    /**
     * return a po_infos Excel
     *
     * @param  Request  $request
     * @param  String  $course_code
     * @return file
     */
    public function downloadPOs(Request $request, $course_code)
    {

    }

    /**
     * return a students_ccp_data_template Excel
     *
     * @param  Request  $request
     * @param  String  $course_code
     * @return file
     */
    public function downloadStudentsCCPs(Request $request, $course_code)
    {

        /**
         * TODO:按照一级节点分为不同的SHEET
         * 
         */

        $studentData = [
            ['2014220202001','测试学生1'],
            ['2014220202002','测试学生2'],
            ['2014220202003','测试学生3'],
            ['2014220202004','测试学生4'],
            ['2014220202005','测试学生5'],
        ];
        $leafccps = $this->CCPRepository->leafCCPforCourseByBaseGroup($course_code);
//        dd($tableHead);
        Excel::create('CCP模板',function($excel) use ($studentData, $leafccps){

            foreach ($leafccps as $leafsLKey => $leafs){
//                $tableHead = ['studentID','name'];
                $tableHead = ['studentID','name'];
                foreach ($leafs as $value){
                    array_push($tableHead, $value['name'].'_'.$value['id']);
                }
                $excel->sheet($leafsLKey, function($sheet) use ($studentData, $tableHead){
    //                $sheet->prependRow(1, [
    //                    'test1', 'test2', 'test3', 'test4', 'test5', 'test6'
    //                ]);
                    $sheet->prependRow(1, $tableHead);
//                    $sheet->rows($studentData);
                });
            }
        })->export('xls');

    }

    function characet($data){
      if( !empty($data) ){
        $fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
        if( $fileType != 'UTF-8'){
          $data = mb_convert_encoding($data ,'utf-8' , $fileType);
        }
      }
      return $data;
    }

}
