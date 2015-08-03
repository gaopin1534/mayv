<?php
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");

class mypage_l{
    public function search($form,$user){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $form["votes"] = $db->select("dtb_vote join m_movie using(movie_id)",array("user_id"=>$user["user_id"]),array("vote_date"=>"DESC"));
        return $form;
    }

    public function myPageDateFormat($date){
        return date('Y年m月d日', strtotime($date));
    }
}