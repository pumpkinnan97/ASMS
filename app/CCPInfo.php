<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CCPInfo extends Model
{
    protected $table = "ccp_infos";

    /**
     * Do not maintain the timestamps auto.
     *
     * @var string
     */
    protected $fillable=['id','ccp_code','is_leaf_ccp','name','description','standard_score','expected_score','actual_score','level',
    'ccp_CO_as_weight','ccp_GR_as_weight'];
    public $timestamps = false;
}
