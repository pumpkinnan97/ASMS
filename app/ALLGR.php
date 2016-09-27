<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ALLGR extends Model
{
    protected $table='allgr_infos';
    protected $fillable = ['ALLGR_code', 'name', 'standart_description','ise_description', 'achievment_scale', 'expected_achievement_scale','gr_ALLGR_weight', 'gr_ALLGR_rest_weight'];
    public $timestamps=false;
}
