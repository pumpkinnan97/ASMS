@extends('layouts.admin')

@section('content')
<?php
    // 获取服务器地址
    require_once("../../../app/library/phpCAS");
    $cas_host = "ostec.uestc.edu.cn";
    $cas_context = "authcas";
    $cas_port = "443";
    $url = "https://ostec.uestc.edu.cn/authcas/login?service=http://202.115.16.82:8000/dologin";
    $host = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    //\phpCAS::setDebug();
    // initialize \phpCAS
    phpCAS::client(CAS_VERSION_2_0,$cas_host, $cas_port, $cas_context);
    phpCAS::setServerLoginUrl("https://".$cas_host.":".$cas_port."/".$cas_context."/login?service=http://202.115.16.82:8000/dologin");
    // no SSL validation for the CAS server
    // \phpCAS::setNoCasServerValidation();
    //\phpCAS::setCasServerCACert(C('CAS_CERT_PATH'));
    // force CAS authentication
    phpCAS::forceAuthentication();
    // at this step, the user has been authenticated by the CAS server
    // and the user's login name can be read with \phpCAS::getUser().
    // logout if desired
    if (isset($_REQUEST['logout'])) {
        $param=array("service"=>"https://".$cas_host.":".$cas_port."/".$cas_context."/login");//退出登录后返回
        phpCAS::logout($param);
    }
?>
@endsection
