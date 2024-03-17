<?php
/*
* index file
* This is the main api - endpoint
* put your code below.
*/
ini_set('display_errors', 0);
$request = $_POST["request"];
require __DIR__ . '/../../vendor/config.php';
require __DIR__ . '/../../vendor/sleekcommerce/init.inc.php';
try
{
  require __DIR__ . '/../../vendor/api_security.inc.php';
  switch ($request) {
      case 'sample-request' :
              $response=array("obj"=>"sample-reponse","msg"=>"sample-message","email"=>$_POST["receiver"]);
              break;
       default:
              throw new Exception("REQUEST_NOT_VALID");
              break;
  }
}
catch(Exception $e)
 {
  $response=array("obj"=>"error","msg"=>$e->getMessage());
  die(json_encode($response));
 }
die(json_encode($response));

?>
