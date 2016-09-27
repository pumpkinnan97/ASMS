<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use \Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Repositories\CCPRepository;
use App\CCPInfo;
use App\StudentCCP;
use App\CourseInfo;

class UploadController extends Controller
{
    protected $CourseCode;
    /**
     * The CCP repository instance.
     *
     */
    protected $CCPRepository;

    private $course_code;

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
     * upload students' CCP information excel
     *
     * @param  Request $request
     * @param  String $course_code
     * @return
     */
    public function uploadCCPs(Request $request, $course_code)
    {
        //判断请求中是否包含name=file的上传文件
        if (!$request->hasFile('file')) {
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if (!$file->isValid()) {
            exit('文件上传出错！');
        }

        //判断文件类型是否正确
        $this->course_code = $request->course_code;

        //

        $destPath = public_path('uploads');
        if (!file_exists($destPath))
            mkdir($destPath, 0755, true);
        $filename = time() . '.xls';
        if (!$file->move($destPath, $filename)) {
            header("Content-Type:text/html;chatset=utf-8");
            echo('保存文件失败！');
            return;
        }
        //解析excel
        Excel::load($destPath . '/' . $filename, function ($reader) {
            $results = $reader->all();
            // 验证表名称是否正确
            $course_code = "";
            foreach ($results as $sheet) {
                $sheetTitle = $sheet->getTitle();
                $tempArr = explode("_", $sheetTitle);
                if (count($tempArr) <= 1) {
                    header("Content-Type:text/html;chatset=utf-8");
                    echo('模板文件出错，请重新下载！');
                    return;
                }
                $name = $tempArr[0];
                $id = $tempArr[1];
                $CCPinfo = CCPInfo::find($id);
                if (empty($course_code)) {
                    $course_code = $CCPinfo->course_code;
                } else if ($course_code != $CCPinfo->course_code) {
                    header("Content-Type:text/html;chatset=utf-8");
                    echo('模板文件出错，请重新下载！');
                    return;
                } else if ($name != $CCPinfo->name) {
                    header("Content-Type:text/html;chatset=utf-8");
                    echo('模板文件出错，请重新下载！');
                    return;
                }
            }
//            header("Content-Type:text/html;chatset=utf-8");
//            echo('表名验证通过');
//            return;

            $CCPInfos = CCPInfo::where('course_code', $this->course_code)->get();
            foreach ($CCPInfos as $value) {
                StudentCCP::where('ccp_code', $value->id)->delete();
            }
                // 分表验证单独数据
            foreach ($results as $sheet) {
                $res = $sheet->toArray();
                if (empty($res))
                    continue;
                foreach ($res as $subKey => $subValue) {
                    // 不为空则取第一行验证
                    if ($subKey == 0) {
                        $jud = $res[0];
                        foreach ($jud as $judKey => $judValue) {
                            if ($judKey == 'studentid' || $judKey == 'name')
                                continue;
                            $tempArr = explode("_", $judKey);
                            if (count($tempArr) <= 1) {
                                header("Content-Type:text/html;chatset=utf-8");
                                echo('模板文件出错，请重新下载！');
                                return;
                            }
                            $name = $tempArr[0];
                            $id = $tempArr[1];
                            $CCPinfo = CCPInfo::where('id', $id)->get();
                            foreach ($CCPinfo as $tempValue)
                                $CCPinfoJud = $tempValue;
                            if (empty($CCPinfoJud)) {
                                header("Content-Type:text/html;chatset=utf-8");
                                echo('模板文件出错，请重新下载！');
                                return;
                            }
                        }
                    }
//                    foreach ($subValue as $key => $value) {
//                        if ($key == 'studentid') {
//                            $studentid = $value;
//                            continue;
//                        }
//                        if ($key == 'name') {
//                            $name = $value;
//                            continue;
//                        }
//                        if ($value == 0 || $value == "0") {
//                            continue;
//                        }
//                        $tempArr = explode("_", $key);
//                        // 删除所有之前的CCP
//                        StudentCCP::where('ccp_code', $tempArr[1])->delete();
//                    }
                    // 录入数据
//                    DB::beginTransaction();
                    // 录入CCP
                    $studentid = null;
                    $name = null;
                    foreach ($subValue as $key => $value) {
                        if ($key == 'studentid') {
                            $studentid = $value;
                            continue;
                        }
                        if ($key == 'name') {
                            $name = $value;
                            continue;
                        }
                        if ($value == 0 || $value == "0") {
                            continue;
                        }
                        $StudentCCP = new StudentCCP();
                        $StudentCCP->student_id = $studentid;
                        $tempArr = explode("_", $key);
                        $StudentCCP->ccp_code = $tempArr[1];
                        $StudentCCP->score = $value;
                        // 判断是否存在
                        $StudentCCP->save();
//                            if(!$StudentCCP->save()){
//                                DB::rollback();
//                                header("Content-Type:text/html;chatset=utf-8");
//                                echo('上传失败！');
//                                return;
//                            }
                    }
//                    DB::commit();
                }
            }

            header("Content-Type:text/html;chatset=utf-8");
            echo('上传完成！');
            return;
        });

    }

    public function upLoadCCPTemp(Request $request, $course_code)
    {
        //判断请求中是否包含name=file的上传文件
        if (!$request->hasFile('file')) {
            exit('上传文件为空！');
        }
        $file = $request->file('file');
        //判断文件上传过程中是否出错
        if (!$file->isValid()) {
            exit('文件上传出错！');
        }

        //判断文件类型是否正确


        //

        $destPath = public_path('uploads');
        if (!file_exists($destPath))
            mkdir($destPath, 0755, true);
        $filename = time() . '.xls';
        if (!$file->move($destPath, $filename)) {
            header("Content-Type:text/html;chatset=utf-8");
            echo('保存文件失败！');
            return;
        }
        $this->CourseCode = $course_code . "";
        //解析excel
        Excel::load($destPath . '/' . $filename, function ($reader) {
            // 验证是否有course_code
            $course_code = $this->CourseCode . "";
            $courseInfo = CourseInfo::where('course_code', $course_code)->get();
            foreach ($courseInfo as $value)
                $tempName = $value['name'];
            if (empty($tempName)) {
                header("Content-Type:text/html;chatset=utf-8");
                echo('课程id错误');
                return;
            }
            $results = $reader->all();
            if (empty($results)) {
                header("Content-Type:text/html;chatset=utf-8");
                echo('模板不能为空！');
                return;
            }
//            if (count($results) != 1) {
//                header("Content-Type:text/html;chatset=utf-8");
//                echo('模板只能有且只有一张表！');
//                return;
//            }
            $validateArr = array();
            foreach ($results as $oneKey => $oneValue) {
                $res = $oneValue->toArray();
                // 验证表头通过
                foreach ($res as $checkKey => $checkValue) {
                    // 验证所有course_code相同且等于所传递的course_code
                    switch ($checkKey) {
                        case "term_id": {
                            $termArr = explode("-", $checkValue);
                            if (count($termArr) != 3 || $termArr[1] - $termArr[0] != 1) {
                                header("Content-Type:text/html;chatset=utf-8");
                                echo(($oneKey + 1) . '行term_id错误！');
                                return;
                            }
                            break;
                        }
                        case "course_code": {
                            if ($checkValue != $course_code) {
                                header("Content-Type:text/html;chatset=utf-8");
                                echo(($oneKey + 1) . '行course_code错误！');
                                return;
                            }
                            break;
                        }
                        case "ccp_code": {
                            $validateArr[$oneKey]['ccp_code'] = $checkValue;
                            break;
                        }
                        case "is_leaf_ccp": {
                            break;
                        }
                        case "name": {
                            break;
                        }
                        case "description": {
                            break;
                        }
                        case "standard_score": {
                            if ($checkValue == 0 || $checkValue == "" || $checkValue == null) {
                                header("Content-Type:text/html;chatset=utf-8");
                                echo(($oneKey + 1) . '行standard_score不能为0！');
                                return;
                            } else {
                                $validateArr[$oneKey]['standard_score'] = $checkValue;
                            }
                            break;
                        }
                        case "level": {
                            $validateArr[$oneKey]['level'] = $checkValue;
                            break;
                        }
                        default: {
                            header("Content-Type:text/html;chatset=utf-8");
                            echo('模板title错误！');
                            return;
                        }
                    }
                }
            }
            // 验证code
//            $flag = $this->__validateCCPCode($validateArr,0);
//            if($flag == false){
//                header("Content-Type:text/html;chatset=utf-8");
//                echo('模板错误！');
//                return;
//            }
            // 删除所有之前的CCP
            CCPInfo::where('course_code', $course_code)->delete();
            // 录入CCP
            foreach ($results as $oneKey => $oneValue) {
                $res = $oneValue->toArray();
                // 验证表头通过
                $CCPInfo = new CCPInfo();
                foreach ($res as $checkKey => $checkValue) {
                    // 验证所有course_code相同且等于所传递的course_code
                    switch ($checkKey) {
                        case "term_id": {
                            break;
                        }
                        case "course_code": {
                            $CCPInfo->course_code = $checkValue;
                            break;
                        }
                        case "ccp_code": {
                            $CCPInfo->ccp_code = $checkValue;
                            break;
                        }
                        case "is_leaf_ccp": {
                            $CCPInfo->is_leaf_ccp = $checkValue;
                            break;
                        }
                        case "name": {
                            $CCPInfo->name = $checkValue ?: "";
                            break;
                        }
                        case "description": {
                            $CCPInfo->description = $checkValue ?: "";
                            break;
                        }
                        case "standard_score": {
                            $CCPInfo->standard_score = $checkValue;
                            break;
                        }
                        case "level": {
                            $CCPInfo->level = $checkValue;
                            break;
                        }
                    }
                }
                $CCPInfo->ccp_code = $CCPInfo->course_code . "_" . $CCPInfo->ccp_code;
                $CCPInfo->save();
            }
            header("Content-Type:text/html;chatset=utf-8");
            echo('录入完成！');
            return;
        });
    }

    private function __validateCCPCode($validateArr, $level = 0)
    {
        // 如果是第一次循环，检测是否只有一个根节点
        if ($level == 0) {
            $countZeroLevel = 0;
            foreach ($validateArr as $value) {
                if ($value['level'] == 0)
                    $countZeroLevel++;
            }
            if ($countZeroLevel != 1) {
                header("Content-Type:text/html;chatset=utf-8");
                echo('模板level为0的节点只允许存在一个');
                return false;
            }
        }
        // 判断是否是最终节点
        $countFlag = 0;
        foreach ($validateArr as $value) {
            if ($value['level'] == $level + 1) {
                $countFlag++;
            }
        }
        if ($countFlag == 0)
            return true;
        // 获取当前level列表组
        $currentValidateArr = array();
        foreach ($validateArr as $value) {
            if ($value['level'] == $level) {
                $currentValidateArr[] = $value;
            }
        }
        // 将当前的level对应的子节点汇总
        foreach ($currentValidateArr as $currentKey => $currentValue) {
            // 获取所有level大于0的开启递归检测
            $subTempValidateArr = array();
            $totalTempNum = 0;
            foreach ($validateArr as $value) {
                if ($value['level'] == $level + 1 && preg_match("/" . $currentValue['ccp_code'] . ".*/", $value['ccp_code']) && (count(explode("_", $value['ccp_code'])) - 1) == $level + 1) {
                    $subTempValidateArr[] = $value;
                    $totalTempNum += $value['standard_score'];
                }
            }
            // 验证子节点加和是否等于父节点
            if ($currentValue['standard_score'] != $totalTempNum && $level != 0 && !empty($subTempValidateArr)) {
                header("Content-Type:text/html;chatset=utf-8");
                echo($currentValue['ccp_code'] . '子节点分数相加不等于该节点分值！');
                return false;
            }
        }
        // 验证下一级
        return $this->__validateCCPCode($validateArr, $level + 1);
    }


    /**
     *
     *
     * @param  Request $request
     * @param  String $course_code
     * @return
     */
    public function downloadGRs(Request $request, $course_code)
    {

    }

    /**
     *
     *
     * @param  Request $request
     * @param  String $course_code
     * @return
     */
    public function downloadCOs(Request $request, $course_code)
    {

    }

    /**
     *
     *
     * @param  Request $request
     * @param  String $course_code
     * @return
     */
    public function downloadPOs(Request $request, $course_code)
    {

    }

    /**
     *
     *
     * @param  Request $request
     * @param  String $course_code
     * @return
     */
    public function downloadStudentsCCPs(Request $request, $course_code)
    {

    }
}
