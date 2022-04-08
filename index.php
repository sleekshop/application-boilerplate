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
            echo $twig->render('error.html', ['data' =>  '404 Not Found!!!'] );
            break;
        case '/home' :
            echo $twig->render('index.html', ['data' =>  'Welcome Sendinblue','path' => $app_path,] );
            break;
        case '/settings' :
           $data = file_get_contents(__DIR__.'/vendor/config.json');
           $data_array = json_decode($data);
           $success = 0;
           //data in our POST
           if(isset($_POST['add'])){
              $data_array->SERVER           = $_POST['SERVER'];
              $data_array->LICENCE_USERNAME = $_POST['LICENCE_USERNAME'];
              $data_array->LICENCE_PASSWORD = $_POST['LICENCE_PASSWORD'];
              $data_array->APPLICATION_TOKEN = $_POST['APPLICATION_TOKEN'];

              $data_array = json_encode($data_array, JSON_PRETTY_PRINT);
              file_put_contents(__DIR__.'/vendor/config.json', $data_array);
              $success = 1;
            }
            echo $twig->render('settings.html', ['data' =>  'Configuration Settings','config_data'=>$data_array,'response'=>$success,'path' => $app_path] );
            break;
        default:
            if(empty($_GET["token"])){
                echo $twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] );
            }else{
                $data = $jsondecoded;
                echo $twig->render('index.html', ['data' =>  'Welcome Sendinblue','path' => $app_path] );
                break;
            }
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
