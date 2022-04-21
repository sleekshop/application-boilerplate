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
$remote_session = $_GET["ses"];
switch ($request) {
    case '/' :
            echo $twig->render('error.html', ['data' =>  '404 Not Found!!!'] );
            break;
    case '/home' :
            echo $twig->render('index.html', ['data' =>  'Welcome Sendinblue','path' => $app_path,'token'=>$_GET["token"],'remote_session'=>$remote_session] );
            break;
    case '/settings' :
             $data_array = $myarray;
             $success = 0;
             $server            = $data_array['SERVER'];
             $licence_username  = $data_array['LICENCE_USERNAME'];
             $application_token = $data_array['APPLICATION_TOKEN'];
             //data in our POST
             if(isset($_POST['add'])){
                $data_array['SERVER']             = $_POST['SERVER'];
                $data_array['LICENCE_USERNAME']   = $_POST['LICENCE_USERNAME'];
                $data_array['LICENCE_PASSWORD']   = $_POST['LICENCE_PASSWORD'];
                $data_array['APPLICATION_TOKEN']  = $_POST['APPLICATION_TOKEN'];

                //$data_array = json_encode($data_array, JSON_PRETTY_PRINT);
                file_put_contents(__DIR__.'/vendor/config.php',
                    "<?php\n\$myarray = "
                      .var_export($data_array, true)
                    .";\n?>"
                  );
                  $data_message = "Configuration Updated!!";
                  $sr=new SleekshopRequest($data_array);
                  $res=$sr->instant_login($_GET["token"]);
                  $jsondecoded = json_decode($res,true);
                  if($jsondecoded['status'] == "SUCCESS"){
                    echo $twig->render('settings.html', ['data' => $data_message,'config_data' =>  $data_array,'path' => $app_path,'token'=>$_GET["token"],'remote_session'=>$jsondecoded['remote_session']]);
                  }else{
                    echo $twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] );
                  }
             }
             else{
                $data_message = "Configuration Settings!!";
                echo $twig->render('settings.html', ['data' => $data_message,'path' => $app_path,'config_data'=>$data_array,'token'=>$_GET["token"],'remote_session'=>$remote_session] );
              }
              break;
    default:
              if(empty($_GET["token"])){
                  echo $twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] );
              }else{
                  //checking for empty values and try instant login and if all good show settings form else permission denied
                  if($myarray['SERVER'] != "" && $myarray['LICENCE_USERNAME'] != "" && $myarray['LICENCE_PASSWORD'] != "" && $myarray['APPLICATION_TOKEN'] != ""){
                        $sr=new SleekshopRequest($myarray);
                        $res=$sr->instant_login($_GET["token"]);
                        $jsondecoded = json_decode($res,true);
                        if($jsondecoded['status'] == "SUCCESS"){
                          echo $twig->render('index.html', ['path' => $app_path,'token'=>$_GET["token"],'remote_session'=>$jsondecoded['remote_session']]);
                        }else{
                          echo $twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] );
                        }
                  }else{
                    echo $twig->render('index.html', ['token'=>$_GET["token"],'path' => $app_path]);
                  }
                }
                break;
}

  /*$data_array = $myarray;
  $success = 0;
  $server            = $data_array['SERVER'];
  $licence_username  = $data_array['LICENCE_USERNAME'];
  $application_token = $data_array['APPLICATION_TOKEN'];
  $licence_password  = $data_array['LICENCE_PASSWORD'];
  //data in our POST
  if(isset($_POST['add'])){
    echo "post action";
     $data_array['SERVER']             = $_POST['SERVER'];
     $data_array['LICENCE_USERNAME']   = $_POST['LICENCE_USERNAME'];
     $data_array['LICENCE_PASSWORD']   = $_POST['LICENCE_PASSWORD'];
     $data_array['APPLICATION_TOKEN']  = $_POST['APPLICATION_TOKEN'];

     //$data_array = json_encode($data_array, JSON_PRETTY_PRINT);
     file_put_contents(__DIR__.'/vendor/config.php',
         "<?php\n\$myarray = "
           .var_export($data_array, true)
         .";\n?>"
       );
     $data_message = "Configuration Updated!!";
     $sr=new SleekshopRequest($data_array);
     $res=$sr->instant_login($_GET["token"]);
     $jsondecoded = json_decode($res,true);
     echo $_GET["token"];
     print_r($data_array);
     print_r($jsondecoded);
     if($jsondecoded['status'] == "SUCCESS"){
       $remote_session = $jsondecoded['remote_session'];
       echo "success and set session";
       $_SESSION['last_action'] = time();
       echo $twig->render('index.html', ['data' => $data_message,'path' => $app_path] );
     }
  }
  else{
     $data_message = "Configuration Settings!!";
     echo $twig->render('settings_default.html', ['data' => $data_message,'config_data'=>$data_array,'path' => $app_path] );
   }*/
?>
