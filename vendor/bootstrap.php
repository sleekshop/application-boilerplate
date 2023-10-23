<?php
/*
* root file for connecting with the sleekshop - backend
* version: 1.0.0
* (c) Demo app - Manisha Sharma
*/
// Load our autoloader
require_once __DIR__.'/autoload.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/../custom/custom.php';
require_once __DIR__.'/sleekcommerce/init.inc.php';

// Specify our Twig templates location
$loader = new Twig_Loader_Filesystem(__DIR__.'/..'.'/templates');

 // Instantiate our Twig
$twig = new Twig_Environment($loader);

$request = strtok($_SERVER["REQUEST_URI"], '?');
$request=explode("/",$request);
$request=array_pop($request);
$request="/".$request;
$app_path = APP_PATH;
$remote_session = $_GET["ses"];

//Now the security - checks to see wether granting access or not
if(SERVER !="" && LICENCE_USERNAME!= "" && LICENCE_PASSWORD != "" && TOKEN != "")
{
if($remote_session!="")
 {
   $sr=new SleekshopRequest();
   $res=$sr->get_user_data($remote_session);
   $res=json_decode($res);
   if((string)$res->object=="error") die($twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] ));
 }
 else
 {
   $token=$_GET["token"];
   $sr=new SleekshopRequest();
   $res=$sr->instant_login($token);
   $res=json_decode($res);
   $status=(string)$res->status;
   if($status!="SUCCESS") die($twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] ));
   $remote_session=(string)$res->remote_session;
 }
}
//End of security - checks.