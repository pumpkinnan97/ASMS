<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CCPToCOASWeightCriteria extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ccp_infos';

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
    protected $fillable = ['ccp_CO_weight', 'ccp_GR_weight'];
}
