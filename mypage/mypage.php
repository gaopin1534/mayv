<?php
include_once("../facebook_sdk/facebook.php");
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");
include_once("../common/util/dateUtil.php");
$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);
$facebook = new Facebook($config);
$userId = $facebook->getUser();
$form = array();
if(!$userId){
    header('Location:../index.php');
    exit();
}else{
    $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $user = $db->select("m_user",array("facebook_id"=>$userId),"",true);
    if(!$user){
        header('Location:../index.php');
        exit();
    }else{
        $fb_user = $facebook->api('/me?fields=id,name,birthday,gender,hometown','GET');
        $login = '<a href="../mypage/mypage.php">'.$fb_user["name"].'</a>:<a href="./logout/logout.php">ログアウト</a>';
    }
}

include_once("mypage_l.php");
$logic = new mypage_l();
$form = $logic->search($form,$user);
include_once("mypage_v.php");