<?php

// set default timezone in philippines (manila)
define('TIMEZONE', 'Asia/Manila');
date_default_timezone_set(TIMEZONE);

session_start();

require('../Core/PHPMailerAutoload.php');

spl_autoload_register('autoload');

function autoload($class)
{
    $class = str_replace('\\', '/', $class);
    $class = str_replace('Core/', '', $class);
    
    if (file_exists($class . '.php')) {
        require_once($class . '.php');
    }elseif (file_exists('Core/' . $class . '.php')) {
        require_once('Core/' . $class . '.php');
    }elseif (file_exists('../Core/' . $class . '.php')) {
        require_once('../Core/' . $class . '.php');
    }elseif (file_exists('Model/' . $class . '.php')) {
        require_once('Model/' . $class . '.php');
    }elseif (file_exists('../Model/' . $class . '.php')) {
        require_once('../Model/' . $class . '.php');
    }else{
        echo 'Class [ ' . $class . ' ] not found';
    }
}