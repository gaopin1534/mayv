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
                $value = str_replace(",","",substr(trim(pq($tds->elements[TOTAL_SALES_KEY])->text()),1));
                if(empty($movies[$movie_name])){
                    $img = $this->getDetail(TARGET_DOC_ROOT.pq($tds->elements[MOVIE_NAME_KEY])->find("a")->attr("href"));
                    $id = $db->insert("m_movie",array("original_name"=>$movie_name,"total_sales"=>$value,"movie_img"=>$img),true);
                }else{
                    $id = $movies[$movie_name];
                    $db->update("m_movie",array("movie_id"=>$id),array("total_sales"=>$value));
                }
                if(empty($exist_sales[$id])){
                    $sales = str_replace(",","",substr(trim(pq($tds->elements[SALES_KEY])->text()),1));
                    $db->insert("dtb_weekly_sales",array("movie_id"=>$id,"date"=>$date,"sales"=>$sales));
                }
            }
            if($index==21){
                break;
            }
        }
        return true;
    }
    private function getDetail($url){
    $html = file_get_contents($url);
        // Get DOM Object
    $dom = phpQuery::newDocument($html);
    $title_table = $dom["table:nth-of-type(1)"];
    $img_url = pq(pq($title_table)->find("img")->elements[0])->attr("src");
    if(substr($img_url,-3)=="jpg"){
        $data = file_get_contents($img_url, FILE_BINARY);echo $img_url."<br>";
        file_put_contents('../img/'.basename($img_url),$data);
    }
    return basename($img_url);

}

}
