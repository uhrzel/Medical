<?php

class Request{
    public static function uri(){
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public static function method(){
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function get($key){
        return $_GET[$key];
    }

    public static function post($key){
        return $_POST[$key];
    }

    public static function file($key){
        return $_FILES[$key];
    }

    public static function all(){
        return $_REQUEST;
    }

    public static function has($key){
        return isset($_REQUEST[$key]);
    }

    public static function isPost(){
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public static function isGet(){
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    public static function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }

    public static function isSecure(){
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
    }

    public static function parseUrl(){
        if(isset($_GET['url'])){
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}