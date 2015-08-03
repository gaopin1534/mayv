<?php
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
if(!$userId){
    header('Location:../index.php');
    exit();
}else{
    $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $user = $db->select("m_user",array("facebook_id"=>$userId),"",true);
    $admin = $db->select("m_admin",array("user_id"=>$user["user_id"]),"",true);
    if(!$admin){
        header('Location:../index.php');
        exit();
    }
}
$form = array();
include_once("movie_edit_l.php");
$logic = new movie_edit_l();
switch($_REQUEST["mode"]){
    case "submit":
        if($logic->update($_REQUEST)){
            header('Location:./edit_index.php');
            exit();
        }else{
            $form["movie_info"] = $_REQUEST;
            break;
        }
    default:
        $form = $logic->getData($form,$_REQUEST);
        break;

}
include_once("movie_edit_v.php");