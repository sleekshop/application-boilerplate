<?php
/*
* index file
* version: 1.0.0
* (c) Boilerplate for sleekshop applications
* (c) Demo app - Manisha Sharma
*/

require __DIR__ . '/vendor/bootstrap.php';

//define application folder name
define("APP_PATH","hello-world");

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
           $data_array = $myarray;
           $success = 0;
           $server            = $data_array['SERVER'];
           $licence_username  = $data_array['LICENCE_USERNAME'];
           $application_token = $data_array['APPLICATION_TOKEN'];
           $licence_password  = $data_array['LICENCE_PASSWORD'];
           $app_path          = $data_array['APP_PATH'];
           //data in our POST
           if(isset($_POST['add'])){
              $data_array['SERVER']             = $_POST['SERVER'];
              $data_array['LICENCE_USERNAME']   = $_POST['LICENCE_USERNAME'];
              $data_array['LICENCE_PASSWORD']   = $_POST['LICENCE_PASSWORD'];
              $data_array['APPLICATION_TOKEN']  = $_POST['APPLICATION_TOKEN'];
              $data_array['APP_PATH']           = $_POST['APP_PATH'];

              //$data_array = json_encode($data_array, JSON_PRETTY_PRINT);
              file_put_contents(__DIR__.'/vendor/config.php',
                  "<?php\n\$myarray = "
                    .var_export($data_array, true)
                  .";\n?>"
                );
              $data_message = "Configuration Updated!!";
          }
           else{
              $data_message = "Configuration Settings!!";
            }
            echo $twig->render('settings.html', ['data' => $data_message,'config_data'=>$data_array,'path' => $app_path] );
            break;
        default:
            if(empty($_GET["token"])){
                echo $twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] );
            }else{
            //  echo $_GET["token"];
              if($myarray['SERVER'] != "" && $myarray['LICENCE_USERNAME'] != "" && $myarray['LICENCE_PASSWORD'] != "" && $myarray['APPLICATION_TOKEN'] != "" ){
                    $sr=new SleekshopRequest($myarray);
                    $res=$sr->instant_login($_GET["token"]);
                    //echo $res;
                    //die;
                    $jsondecoded = json_decode($res,true);
                    print_r($jsondecoded);
                  //  die;
                    //print_r($myarray);
                    if($jsondecoded['status'] == "success"){
                      echo $twig->render('index.html', ['data' =>  'jsondecoded','path' => $app_path] );
                    }else{
                      echo $twig->render('error.html', ['data' =>  $jsondecoded['status'],'path' => $app_path] );
                    }
                }else{
                  echo $twig->render('index.html', ['data' =>  'Welcome Sendinblue','path' => $app_path] );
                }
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
