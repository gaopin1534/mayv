<?php
include_once("./getRanking_l.php");
$logic = new getRanking_l;
if($logic->getRanking()){
    echo "done";
}else{
    echo "failed";
}