<?php
include_once("../setting/constants.php");
class dateUtil{
    static function dateFormat($date_string){
        $elem = explode(" ",$date_string);
        $date = explode("-",$elem["1"]);
        return end($elem)."-".constants::$months[$elem[0]]."-".$date[0];
    }

    static function listDateFormat($date){
        return date('Y年m月d日', strtotime($date));
    }
}