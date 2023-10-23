<?php
/*
* index file
* version: 1.0.0
* (c) Boilerplate for sleekshop applications
* (c) Demo app - Manisha Sharma(ms@sleekshop.io)
*/
ini_set('display_errors', 0);
//define application folder name
define("APP_PATH",basename(__DIR__));

require __DIR__ . '/vendor/bootstrap.php';


  switch ($request) {
      case '/' :
              echo $twig->render('error.html', ['data' =>  '404 Not Found!!!','path' => $app_path]);
              break;
      case '/home' :
              echo $twig->render('index.html', ['data' =>  'Welcome Application Boilerplate','path' => $app_path,'token'=>$_GET["token"],'remote_session'=>$remote_session] );
              break;
      case '/settings' :
               $data_array = array("SERVER"=>SERVER,"LICENCE_USERNAME"=>LICENCE_USERNAME,"LICENCE_PASSWORD"=>LICENCE_PASSWORD,"APPLICATION_TOKEN"=>TOKEN);
               $success = 0;
               //data in our POST
               if(isset($_POST['add'])){
                  $data_array['SERVER']             = $_POST['SERVER'];
                  $data_array['LICENCE_USERNAME']   = $_POST['LICENCE_USERNAME'];
                  $data_array['LICENCE_PASSWORD']   = $_POST['LICENCE_PASSWORD'];
                  $data_array['APPLICATION_TOKEN']  = $_POST['APPLICATION_TOKEN'];

                  //$data_array = json_encode($data_array, JSON_PRETTY_PRINT);
                  $c='
                  <?php
                  define("SERVER","'.$data_array['SERVER'].'");
                  define("LICENCE_USERNAME","'.$data_array['LICENCE_USERNAME'].'");
                  define("LICENCE_PASSWORD","'.$data_array['LICENCE_PASSWORD'].'");
                  define("TOKEN","'.$data_array['APPLICATION_TOKEN'].'");
                  ?>
                  ';
                  file_put_contents(__DIR__.'/vendor/config.php',$c);

                  define("SERVER",$data_array['SERVER']);
                  define("LICENCE_USERNAME",$data_array['LICENCE_USERNAME']);
                  define("LICENCE_PASSWORD",$data_array['LICENCE_PASSWORD']);
                  define("TOKEN",$data_array['APPLICATION_TOKEN']);

                    $data_message = "Configuration Updated!!";
                    $sr=new SleekshopRequest();
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
                    if(SERVER != "" && LICENCE_USERNAME != "" && LICENCE_PASSWORD != "" && TOKEN != ""){
                          $sr=new SleekshopRequest();
                          $res=$sr->instant_login($_GET["token"]);
                          $jsondecoded = json_decode($res,true);
                          if($jsondecoded['status'] == "SUCCESS"){
                            echo $twig->render('index.html', ['data' =>  'Welcome Application Boilerplate','path' => $app_path,'token'=>$_GET["token"],'remote_session'=>$jsondecoded['remote_session']]);
                          }else{
                            echo $twig->render('error.html', ['data' =>  'PERMISSION_DENIED','path' => $app_path] );
                          }
                    }else{
                      echo $twig->render('index.html', ['data' =>  'Welcome Application Boilerplate','token'=>$_GET["token"],'path' => $app_path]);
                    }
                  }
                  break;
  }
?>
