<?php
/*
* This file is for securing the application - api
*/
$user=explode("_",LICENCE_USERNAME);
$user=$user[0];
$token=TOKEN;
$sent_user=$_POST["username"];
$sent_token=$_POST["token"];
if($user!=$sent_user OR $token!=$sent_token) throw new Exception("PERMISSION_DENIED");