<?php
require_once("../facebook_sdk/facebook.php");
require_once("../common/setting/constants.php");

$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);

include_once("register_l.php");
$logic = new register_l();
$facebook = new Facebook($config);
$userId = $facebook->getUser();
if(!$userId){
    $loginUrl = $facebook->getLoginUrl(constants::$permissions);
    $login = '<a href="' . $loginUrl . '">Facebookで会員登録</a>';
}else{
    $message = $logic->newRegister($_REQUEST,$facebook);
}

include_once("register_v.php");