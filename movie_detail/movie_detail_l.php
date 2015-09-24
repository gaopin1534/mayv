<?php
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");

class movie_detail_l{
    public function search($form,$movie_id){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $sql = 'SELECT * FROM m_movie AS a JOIN dtb_weekly_sales AS b ON a.movie_id = b.movie_id LEFT OUTER JOIN (SELECT COUNT(*) as wannasee,movie_id as id FROM dtb_vote GROUP BY movie_id) as c on a.movie_id =id WHERE date =(SELECT max(date)  FROM dtb_weekly_sales) AND a.movie_id = '.$movie_id;
        $form["movie_info"] = $db->execSql($sql,true);
        return $form;
    }
    public function getData($form){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $form["actor_list"] = $db->select("m_actor");
        foreach($form["actor_list"] as $val){
            $form["id_to_name"][$val["actor_id"]] = $val["actor_name"];
        }
        $tmp = $db->select("c_movie_actor");
        foreach($tmp as $val){
            $form["actor_list"][$val["movie_id"]][] = $val["actor_id"];
        }
        return $form;
    }
    public function movie_detailDateFormat($date){
        return date('Y年m月d日', strtotime($date));
    }
}