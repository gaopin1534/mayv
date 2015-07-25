<?php
require_once("./facebook_sdk/facebook.php");
require_once("./common/setting/constants.php");
$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);
$facebook = new Facebook($config);
$userId = $facebook->getUser();
if(!$userId){
    $loginUrl = $facebook->getLoginUrl();
    $login = '<a href="' . $loginUrl . '">Login with Facebook</a>';
}else{
    $user = $facebook->api('/me','GET');
    $login = '<img src="https://graph.facebook.com/'.$userId.'/picture"><a href="#">'.$user["name"].'</a>';
}

include_once("index_l.php");
$logic = new index_l();
$ranking = $logic->search();
include_once("index_v.php");