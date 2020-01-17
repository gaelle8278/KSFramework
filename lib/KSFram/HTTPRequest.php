<?php
namespace KSFram;

class HTTPRequest extends ApplicationComponent
{
    public function cookieData($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }
    
    public function isCookie($key)
    {
        return isset($_COOKIE[$key]);
    }
    
    public function getData($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }
    
    public function isGetData($key)
    {
        return isset($_GET[$key]);
    }
    
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public function postData($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
    
    public function isPostData($key)
    {
        return isset($_POST[$key]);
    }
    
    public function requestURI()
    {
        return $_SERVER['REQUEST_URI'];
    }
}