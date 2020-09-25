<?php

class Session
{
    public static function checkSession(){
        return session_status() == PHP_SESSION_ACTIVE;
        //chalu hai ki nai hai
    }

    public static function startSession(){        
        if(!self:: checkSession()){
            session_set_cookie_params(0);
            session_start();
        }
    }

    public static function destroySession(){
        if(self:: checkSession()){
            session_destroy();
        }
    }

    public static function setSession($key, $value){
        self::startSession();
        $_SESSION[$key] = $value;
    }

    public static function hasSession($key){
        if(self::checkSession()&& isset($_SESSION[$key])){
            return true;
        }
        return false;
    }
    public static function getSession($key){
        if(self::hasSession($key)){
            return $_SESSION[$key];//session number
        }
        return null;
    }
    public static function unsetSession($key){
        if(self::hasSession($key)){
            unset($_SESSION[$key]);
        }
    }


}

