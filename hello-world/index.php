<?php
/*
* index file
* version: 1.0.0
* (c) Boilerplate for sleekshop applications
* name - email
*/

require __DIR__ . '/vendor/config/bootstrap.php';
/*$post = [
    'licence_username' => LICENCE_USERNAME,
    'licence_password' => LICENCE_PASSWORD,
    'request'   => "instant_login",
    'token'   => TOKEN,
    'application_token'   => APPLICATION_TOKEN,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://boilerplate.sleekshop.net/srv/service/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
$response = curl_exec($ch);
$jsondecoded = json_decode($response,true);
if($jsondecoded['status'] == "SUCCESS"){
    //var_dump($jsondecoded);
    $data = $jsondecoded;
    echo $twig->render('index.html', ['data' => $data] );
}else{
   $data = "PERMISSION_DENIED";
   echo $twig->render('error.html', ['data' => $data] );
}
*/
$request = strtok($_SERVER["REQUEST_URI"], '?');
$request=explode("/",$request);
$request=array_pop($request);
$request="/".$request;

switch ($request) {
    case '/' :
        echo $twig->render('error.html', ['data' =>  '404 Not Found!!!'] );;
        break;
    case '/home' :
        echo $twig->render('index.html', ['data' =>  'Login successfull!!!'] );
        break;
    case '/settings' :
        echo $twig->render('settings.html', ['data' =>  'Settings Screen!!!'] );
        break;
    default:
        $post = [
            'licence_username' => LICENCE_USERNAME,
            'licence_password' => LICENCE_PASSWORD,
            'request'   => "instant_login",
            'token'   => TOKEN,
            'application_token'   => APPLICATION_TOKEN,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://boilerplate.sleekshop.net/srv/service/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $response = curl_exec($ch);
        $jsondecoded = json_decode($response,true);
        if($jsondecoded['status'] == "SUCCESS"){
            $data = $jsondecoded;
            echo $twig->render('index.html', ['data' =>  'Login successfull!!!'] );
        }else{
           $data = "PERMISSION_DENIED";
           echo $twig->render('error.html', ['data' => $data] );
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
