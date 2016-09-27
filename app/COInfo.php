<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class COInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'co_infos';

    /**
     * The primary key of the table.
     *
     * @var string
     */
//    public $primaryKey = 'co_code';

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
    protected $fillable = ['co_code', 'course_code', 'name','description', 'english_description', 'achivement_scale', 'expected_scale', 'CO_GR_as_weight','ccp_CO_rest_as_weight'];
}
