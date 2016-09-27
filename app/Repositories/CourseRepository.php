<?php

namespace App\Repositories;

use App\CourseInfo;
use App\GRInfo;
/**
* 
*/
class CourseRepository
{
    public function forGR(GRInfo $grInfo)
    {
      return CourseInfo::where('gr_code', $grInfo->gr_code)
                    ->orderBy('credit', 'asc')
                    ->get();
    }
}
