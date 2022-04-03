<?php
/*
* index file
* version: 1.0.0
* (c) Boilerplate for sleekshop applications
* (c) Demo app - Manisha Sharma
*/

require __DIR__ . '/vendor/bootstrap.php';

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

//Getuserdata demo
/*
$instant_login_res = json_decode($response,true);

$post1 = [
    'licence_username' => 'boilerplate_3UkUY6IidJnjHvCQYAka',
    'licence_password' => 'TZ3zEWRs3Xt0new3bVTV',
    'request'   => "get_user_data",
    'session'   => $instant_login_res['remote_session'],
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://boilerplate.sleekshop.net/srv/service/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post1));
$response = curl_exec($ch);
var_export(json_decode($response,true));*/
?>
