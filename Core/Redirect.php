<?php

class Redirect{
    public static function to($location, $refresh = null){
        if($refresh){
            header('Refresh: ' . $refresh . '; url=' . $location);
        }else{
            header('Location: ' . $location);
        }
    }

    public static function back(){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function refresh(){
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}