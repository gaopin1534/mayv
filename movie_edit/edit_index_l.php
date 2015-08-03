<?php
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");

class edit_index_l{
    public function search(){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $sql = 'SELECT * FROM m_movie AS a LEFT OUTER JOIN (SELECT * FROM dtb_weekly_sales WHERE date =(SELECT max(date) FROM dtb_weekly_sales)) as b using(movie_id) LEFT OUTER JOIN (SELECT COUNT(*) as wannasee,movie_id as id FROM dtb_vote GROUP BY movie_id) as c on a.movie_id =id ORDER BY sales DESC;';
        return $db->execSql($sql);
    }
}