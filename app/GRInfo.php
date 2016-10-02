<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GRInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gr_infos';

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
    protected $fillable = ['gr_code', 'name', 'standart_description','ise_description', 'achievment_scale', 'expected_achievement_scale','gr_ALLGR_weight', 'CO_GR_rest_as_weight','ccp_GR_rest_as_weight'];

}
