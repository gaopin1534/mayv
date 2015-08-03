<?php
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");

class movie_edit_l{
    public function getData($form,$post){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $form["movie_info"] = $db->select("m_movie",array("movie_id"=>$post["movie_id"]),"",true);
        return $form;
    }
    public function update($post){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $vals = array(
            'movie_id' => $post['movie_id'],
            'movie_name' => $post['movie_name'],
            'outline' => $post['outline'],
            'directer' => $post['directer'],
            'explanation' => $post['explanation'],
            'us_published' => $post['us_published'],
            'jp_published' => $post['jp_published'],
            'duration' => $post['duration'],
            'original_name' => $post['original_name'],
            'video_url' => $post['video_url'],
            'total_sales' => $post['total_sales'],
            'actor_name1' => $post['actor_name1'],
            'actor_name2' => $post['actor_name2']
        );
        return $db->update("m_movie",array("movie_id"=>$post["movie_id"]),$vals);
    }
}