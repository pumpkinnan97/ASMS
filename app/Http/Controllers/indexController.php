<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use App\Task;
// use App\Repositories\TaskRepository;
use App\Repositories\CourseRepository;
use App\CourseInfo;

class indexController extends Controller
{
    protected $CourseRepository;
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    // public function index(Request $request)
    public function index(Request $request)
    {
        return view('app.index', [
            "Courses" => CourseInfo::all(),
        ]);
    }

}
