<?php
include_once("phpquery/phpQuery-onefile.php");
include_once("common/constants.php");
$html = file_get_contents("http://www.boxofficemojo.com/weekend/chart/");

// Get DOM Object
$dom = phpQuery::newDocument($html);
$trs = $dom[TARGET_TR];
$index = 0;
foreach ($trs as $key => $value) {
    $index++;
    if($index != 1){
        $tds = pq($value)->find("td");
        echo pq($tds->elements[MOVIE_NAME_KEY])->text().";".pq($tds->elements[SALES_KEY])->text()."<br>";
    }
}