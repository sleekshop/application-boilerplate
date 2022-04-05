<?php
/*
* index file
* version: 1.0.0
* (c) Boilerplate for sleekshop applications
* (c) Demo app - Manisha Sharma
*/

require __DIR__ . '/vendor/bootstrap.php';
/*
* include all custom application files
* Example:- require __DIR__ . '/ctl/yourfilename.php';
*/

$request = strtok($_SERVER["REQUEST_URI"], '?');
$request=explode("/",$request);
$request=array_pop($request);
$request="/".$request;

$app_path = APP_PATH;

switch ($request) {
    case '/' :
        echo $twig->render('error.html', ['data' =>  '404 Not Found!!!'] );;
        break;
    case '/home' :
        echo $twig->render('index.html', ['data' =>  'Login successfull!!!','path' => $app_path,] );
        break;
    case '/settings' :
        echo $twig->render('settings.html', ['data' =>  'Settings Screen!!!','path' => $app_path] );
        break;
    case '/about' :
        echo $twig->render('settings.html', ['data' =>  'About Screen!!!','path' => $app_path] );
        break;
    default:
        $sr=new SleekshopRequest();
        $res=$sr->instant_login();
        $jsondecoded = json_decode($res,true);
        if($jsondecoded['status'] == "SUCCESS"){
            $data = $jsondecoded;
            echo $twig->render('index.html', ['data' =>  'Login successfull!!!','path' => $app_path] );
        }else{
           $data = "PERMISSION_DENIED";
           echo $twig->render('error.html', ['data' => $data,'path' => $app_path] );
        }
        break;
}
?>
