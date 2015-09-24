<?php
include_once("../common/setting/constants.php");
include_once("../common/util/sqlInterface.php");
include_once("../common/setting/db_setting.php");

class movie_edit_l{
    public function getData($form,$post){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $form["movie_info"] = $db->select("m_movie",array("movie_id"=>$post["movie_id"]),"",true);
        $form["actor_list"] = $db->select("m_actor");
        foreach($form["actor_list"] as $val){
            $form["id_to_name"][$val["actor_id"]] = $val["actor_name"];
        }
        $form["actor_list"] = $db->select("c_movie_actor",array("movie_id"=>$post["movie_id"]));
        return $form;
    }
    public function update($post){
        $db = new sqlInterface(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $vals = array(
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
        );
        $db->delete("c_movie_actor",array("movie_id"=>$post["movie_id"]));
        if(!empty($post['actor_name1'])){
            $db->insert("c_movie_actor",array("movie_id"=>$post["movie_id"],"actor_id"=>$this->chkActor($db,$post['actor_name1'])));
        }
        if(!empty($post['actor_name2'])){
            $db->insert("c_movie_actor",array("movie_id"=>$post["movie_id"],"actor_id"=>$this->chkActor($db,$post['actor_name2'])));
        }
        return $db->update("m_movie",array("movie_id"=>$post["movie_id"]),$vals);
    }
    private function chkActor($db,$name){
        $actor = $db->select("m_actor",array("actor_name"=>trim($name)),null,true);
        if(!$actor){
            return $db->insert("m_actor",array("actor_name"=>$name),true);
        }else{
            return $actor["actor_id"];
        }
    }
}