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
    public $timestamps = false;
}
