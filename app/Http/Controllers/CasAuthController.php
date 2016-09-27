<?php

namespace App\Http\Controllers;


class CasAuthController extends Controller{
    protected $cas_host = "https://ostec.uestc.edu.cn";
    protected $cas_context = "authcas";
    protected $cas_port = "443";
    protected $url = "https://ostec.uestc.edu.cn/authcas/login?service=http://202.115.16.82:8000/dologin";

    public function login() {
        \phpCAS::client(CAS_VERSION_2_0, $this->cas_host, $this->cas_port, $this->cas_context);
        \phpCAS::setNoCasServerValidation();
        if (\phpCAS::checkAuthentication()) {

        }else{
            \phpCAS::forceAuthentication();
        }
        dump(\phpCAS::getUser());
    }

    public function logout() {
        \phpCAS::setDebug();
        \phpCAS::client(CAS_VERSION_2_0, $this->cas_host, $this->cas_port, $this->cas_context);
        \phpCAS::setNoCasServerValidation();
        \phpCAS::logoutWithRedirectService($this->url);
    }
}