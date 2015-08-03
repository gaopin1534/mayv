<?php
include_once("../phpquery/phpQuery-onefile.php");
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");
include_once("../common/util/dateUtil.php");
class getRanking_l{
    public function getRanking(){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $html = file_get_contents(SOURCE_URL);
        // Get DOM Object
        $dom = phpQuery::newDocument($html);
        $title_table = $dom["table:nth-of-type(2)"];
        $date = dateUtil::dateFormat(trim(pq(pq($title_table)->find("b")->elements[TITLE_KEY])->text()));
        $trs = $dom[TARGET_TR];
        $index = 0;
        $tmp_movies = $db->select("m_movie");
        $movies = array();
        foreach($tmp_movies as $val){
            $movies[$val["original_name"]] = $val["movie_id"];
            $totals[$val["movie_id"]] = $val["total_sales"];
        }
        $tmp_sales = $db->select("dtb_weekly_sales",array("date"=>$date));
        foreach($tmp_sales as $val){
            $exist_sales[$val["movie_id"]] = 1;
        }
        foreach ($trs as $key => $value) {
            $index++;
            if($index != 1 && $index < count($trs)){
                $tds = pq($value)->find("td");
                $movie_name = trim(pq($tds->elements[MOVIE_NAME_KEY])->text());
                if(empty($movies[$movie_name])){
                    $id = $db->insert("m_movie",array("original_name"=>$movie_name));
                }else{
                    $id = $movies[$movie_name];
                }
                if(empty($exist_sales[$id])){
                    $sales = str_replace(",","",substr(trim(pq($tds->elements[SALES_KEY])->text()),1));
                    $db->insert("dtb_weekly_sales",array("movie_id"=>$id,"date"=>$date,"sales"=>$sales));
                    $value = $totals[$id] + $sales;
                    $db->update("m_movie",array("movie_id"=>$id),array("total_sales"=>$value));
                }
            }
        }
        return true;
    }

}
