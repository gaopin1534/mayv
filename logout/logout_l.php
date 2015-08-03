<?php
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");

class vote_l{
    public function lastVoteChk($userId,$form){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $timestamp = date('Y-m-d 00:00:00',mktime(0, 0, 0));
        $tmp = $db->select("dtb_vote","vote_date>'".$timestamp."'","",true);
        if($tmp){
            return "本日は投票済みです";
        }else{
            if($db->insert("dtb_vote",array("facebook_id"=>$userId,"movie_id"=>$form["movie_id"],"vote_date"=>"now()"))){
                return "投票しました";
            }else{
                return "失敗しました";
            }
        }
    }
}