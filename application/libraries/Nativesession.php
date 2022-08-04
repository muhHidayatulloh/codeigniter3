<?php

if (!defined(BASEPATH)) exit('No dorect script access allowed');

class Nativesession
{
    public function __construct()
    {
        session_start();
    }
    //function untuk meng-set session
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    // function untuk memanggil session
    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    public function delete($key)
    {
        unset($_SESSION[$key]);
    }
}
