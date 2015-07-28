<?php
include_once("./facebook_sdk/facebook.php");
include_once("./common/setting/constants.php");
include_once("./common/util/sqlInterface.php");
include_once("./common/setting/db_setting.php");
$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);
$facebook = new Facebook($config);
$userId = $facebook->getUser();
if(!$userId){
    $loginUrl = $facebook->getLoginUrl(constants::$permissions);
    $login = '<a href="' . $loginUrl . '">Login with Facebook</a>:<a href="./register/register.php">会員登録</a>';
}else{
    $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $user = $db->select("m_user",array("facebook_id"=>$userId),"",true);
    if(!$user){
        $login = '<a href="./register/register.php">会員登録</a>';
    }else{
        $user = $facebook->api('/me?fields=id,name,birthday,gender','GET');
        $login = '<img src="https://graph.facebook.com/'.$userId.'/picture"><a href="#">'.$user["name"].'</a>';
    }
}

include_once("index_l.php");
$logic = new index_l();
$ranking = $logic->search();
include_once("index_v.php");