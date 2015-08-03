<?php
require_once("../facebook_sdk/facebook.php");
require_once("../common/setting/constants.php");
$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);
$facebook = new Facebook($config);
$userId = $facebook->getUser();if(!$userId){
    header('Location:../index.php');
    exit();
}

$logoutUrl = $facebook->getLogoutUrl();
$facebook->destroySession();
header("Location: ".$logoutUrl);