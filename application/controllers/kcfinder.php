<?php
class Kcfinder extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
        is_logged_in();
    }

    public function clear()
    {
        $_SESSION['ses_kcfinder'] = array();
        $_SESSION['ses_kcfinder']['disabled'] = false;
    }
}
