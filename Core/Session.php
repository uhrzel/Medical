<?php

class Session{
    private $conn;

    public function __construct(){
        $this->conn = Database::getInstance();
    }

    public static function start(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
    }

    public static function destroy(){
        session_destroy();
    }

    public static function id(){
        return session_id();
    }

    public static function exists($name){
        return (isset($_SESSION[$name])) ? true : false;
    }

    public static function put($name, $value){
        return $_SESSION[$name] = $value;
    }

    public static function get($name){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }else{
            return false;
        }
    }

    public static function delete($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }
    }

    public static function display($name){
        if(self::exists($name)){
            echo self::get($name);
            self::delete($name);
        }
    }

    public static function display_session_msg(){
        if(self::exists('success')){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo self::get('success');
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            self::delete('success');
        }elseif(self::exists('error')){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo self::get('error');
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            self::delete('error');
        }else{
            return false;
        }
    }

    public static function flash($name, $string = ''){
        if(self::exists($name)){
            $session = self::get($name);
            self::delete($name);
            return $session;
        }else{
            self::put($name, $string);
        }
    }
}