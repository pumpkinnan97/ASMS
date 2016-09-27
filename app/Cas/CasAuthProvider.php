<?php

namespace cas;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\GenericUser;

class CasAuthProvider implements UserProvider {

    protected $cas_host = "https://ostec.uestc.edu.cn";
    protected $cas_context = "authcas";
    protected $cas_port = "443";
    protected $url = "https://ostec.uestc.edu.cn/authcas/login?service=http://202.115.16.82:8000/dologin";
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $id
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveById($id) {
        return $this->caSUSEr();
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByCredentials(array $credentials) {
        return $this->casUser();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Auth\UserInterface  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials) {
        return true;
    }

    protected function casUser() {
//        $cas_host = \Config::get('app.cas_host');
        $cas_host = $this->cas_host;
        //dump($cas_host);
//        $cas_context = \Config::get('app.cas_context');
        $cas_context = $this->cas_context;
//        $cas_port = \Config::get('app.cas_port');
        $cas_port = $this->cas_port;
        \phpCAS::setDebug();
        \phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
        \phpCAS::setNoCasServerValidation();

        if (\phpCAS::isAuthenticated()) {
            $attributes = array(
                'id' => \phpCAS::getUser(),
                'name' => \phpCAS::getUser()
            );
            return new GenericUser($attributes);
        } else {
            //\phpCAS::setServerURL(\Config::get('app.url'));
            \phpCAS::forceAuthentication();
        }
        return null;
    }

    /**
     * Needed by Laravel 4.1.26 and above
     */
    public function retrieveByToken($identifier, $token) {
        return new \Exception('not implemented');
    }

    /**
     * Needed by Laravel 4.1.26 and above
     */
    public function updateRememberToken(Authenticatable $user, $token) {
        return new \Exception('not implemented');
    }

}

?>