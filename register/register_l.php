<?php
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");
require_once("../facebook_sdk/facebook.php");
$config = array(
    'appId'  => APP_ID,
    'secret' => APP_SECRET
);
class register_l{
    public function newRegister($form,$facebook){
        $user = $facebook->api('/me?fields=id,name,birthday,gender,hometown,email','GET');
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $tmp = $db->select("m_user",array("facebook_id"=>$user["id"]),"",true);
        if($tmp){
            return "すでに登録されています";
        }else{
            $elms = explode("/",$user["birthday"]);
            if($db->insert("m_user",array("facebook_id"=>$user["id"],"birthday"=>$elms[2]."-".$elms[0]."-".$elms[1],"sex"=>$user["gender"],"email"=>$user["email"],"hometown"=>$user["hometown"]["name"]))){
                return "新規登録しました";
            }else{
                return "登録に失敗しました";
            }
        }
    }
}