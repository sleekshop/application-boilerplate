<?php
/*
* index file
* version: 1.0.0
* (c) Boilerplate for sleekshop applications
* (c) Demo app - Manisha Sharma
*/
//Start our session.
session_start();
//Expire the session if user is inactive for 30
//minutes or more.
$expireAfter = 120;

require __DIR__ . '/vendor/bootstrap.php';

//define application folder name
define("APP_PATH","hello-world");

$request = strtok($_SERVER["REQUEST_URI"], '?');
$request=explode("/",$request);
$request=array_pop($request);
$request="/".$request;
$app_path = APP_PATH;
echo $app_path;
print_r($_SESSION);

if(isset($_SESSION['last_action'])){

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
          echo $twig->render('index.html', ['data' =>  'Welcome Sendinblue','path' => $app_path,] );
          break;
  }

    //Figure out how many seconds have passed
    //since the user was last active.
    $secondsInactive = time() - $_SESSION['last_action'];

    //Convert our minutes into seconds.
    $expireAfterSeconds = $expireAfter * 60;

    //Check to see if they have been inactive for too long.
    if($secondsInactive >= $expireAfterSeconds){
        //User has been inactive for too long.
        //Kill their session.
        session_unset();
        session_destroy();
    }
    echo "session set";
}else{
  echo "session not set";
  if(empty($_GET["token"])){
      echo $twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] );
  }else{
  $data_array = $myarray;
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
       echo "success and set session";
       $_SESSION['last_action'] = time();
       echo $twig->render('index.html', ['data' => $data_message,'path' => $app_path] );
     }
  }
  else{
     $data_message = "Configuration Settings!!";
     echo $twig->render('settings_default.html', ['data' => $data_message,'config_data'=>$data_array,'path' => $app_path] );
   }
 }
}
?>
