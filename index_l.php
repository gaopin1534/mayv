<?php
include_once("./common/setting/constants.php");
include_once("./common/util/sqlInterface.php");
include_once("./common/setting/db_setting.php");

class index_l{
    public function search(){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $sql = 'SELECT * FROM m_movie AS a join dtb_weekly_sales AS b ON a.movie_id = b.movie_id WHERE date =(SELECT max(date) FROM dtb_weekly_sales) ';
        return $db->execSql($sql);
    }
}