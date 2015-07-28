<?php
//直接アクセスされた時の処理
if(!$_REQUEST["movie_id"]){
    header('Location:../index.php');
    exit();
}
require_once("../facebook_sdk/facebook.php");
require_once("../common/setting/constants.php");
$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);
$facebook = new Facebook($config);
$userId = $facebook->getUser();
if(!$userId||!$_REQUEST["movie_id"]){
    header('Location:../index.php');
    exit();
}

include_once("vote_l.php");
$logic = new vote_l();
$message = $logic->lastVoteChk($userId,$_REQUEST);
include_once("vote_v.php");