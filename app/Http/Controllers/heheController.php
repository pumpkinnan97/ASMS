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
class heheController extends Controller{
	function hehe(Request $request){
		return view('GRs.hehe');
	}
}

?>