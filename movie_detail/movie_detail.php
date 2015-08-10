<?php
//直接アクセスされた時の処理
if(!$_REQUEST["movie_id"]){
    header('Location:../index.php');
    exit();
}

include_once("../facebook_sdk/facebook.php");
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");
$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);
$facebook = new Facebook($config);
$userId = $facebook->getUser();
$form = array();
if(!$userId){
    $loginUrl = $facebook->getLoginUrl(constants::$permissions);
    $login = '<a href="' . $loginUrl . '">Login with Facebook</a>:<a href="./register/register.php">会員登録</a>';
}else{
    $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $user = $db->select("m_user",array("facebook_id"=>$userId),"",true);
    if(!$user){
        $login = '<a href="./register/register.php">会員登録</a>';
    }else{
        // $fb_user = $facebook->api('/me?fields=id,name,birthday,gender,hometown','GET');
        $login = '<a href="../mypage/mypage.php">マイページ</a>:<a href="./logout/logout.php">ログアウト</a>';
    }
}

include_once("movie_detail_l.php");
$logic = new movie_detail_l();
$form = $logic->search($form,$_REQUEST["movie_id"]);
include_once("movie_detail_v.php");