<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
session_start();

require_once __DIR__ ."/requirements.php";
date_default_timezone_set('Asia/Kolkata');
$app = __DIR__;



$di = new DependencyInjector();
$di->set('config', new Config());
$di->set('database', new Database($di));
$di->set('hash', new Hash());
$di->set('util', new Util($di));
$di->set('errorHandler', new ErrorHandler());
$di->set('validator', new Validator($di));
$di->set('auth',new Auth($di));
$di->set('tokenHandler',new Tokenhandler($di));

$di->set('mail', MailConfigHelper::getMailer());
$di->get('auth')->build();
$di->get('tokenHandler')->build();

$di->set('user',new User($di));
$di->set('post',new Post($di));
$di->set('category',new Category($di));
// $di->set('adminPost',new Post($di));

if(isset($_COOKIE['token']) && $di->get('tokenHandler')->isValid($_COOKIE['token'],1))
{
   $user = $di->get('tokenHandler')->getUserFromValidToken($_COOKIE['token']);
  //  var_dump($_COOKIE['token']);;
  $di->get('auth')->setAuthSession($user->id);
}
$di->get('user')->deleteActiveToken();

require_once __DIR__ ."/constants.php";
