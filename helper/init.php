<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
session_start();

require_once __DIR__ ."/requirements.php";
date_default_timezone_set('Asia/Kolkata');
$app = __DIR__;



$di = new DependencyInjector();
$di->set('auth',new Auth($di));

$di->get('auth')->build();


if(isset($_COOKIE['token']) && $di->get('tokenHandler')->isValid($_COOKIE['token'],1))
{
   $user = $di->get('tokenHandler')->getUserFromValidToken($_COOKIE['token']);
  //  var_dump($_COOKIE['token']);;
  $di->get('auth')->setAuthSession($user->id);
}
$di->get('user')->deleteActiveToken();

require_once __DIR__ ."/constants.php";
