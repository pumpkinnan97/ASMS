<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentCCP extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_ccps';
    /**
     * Do not maintain the timestamps auto.
     *
     * @var string
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['score', 'student_id', 'ccp_code'];

}
