<?php

class sqlInterface extends mysqli{
    private $db;
    /**
     * __construct description
     * @param string $host     host name you're going to connect
     * @param string $user     user name you're going to log in with
     * @param string $password pass word you're going to log in with
     * @param string $database database name you're going to connect
     */
   function __construct($host,$user,$password,$database) {
        parent::__construct($host,$user,$password,$database);
    }

   /**
    * _query execute a query
    * @param  string $sql    sql string
    * @param  boolean $if_one indicate if the result is one record
    * @return array  $result result
    */
   private function _query($sql,$if_one){
        $result = parent::query($sql);
        if(is_bool($result)||$result == null){
            return $result;
        }
        if($if_one){
            return $result->fetch_assoc();
        }else{
            $tmp = array();
            while($row = $result->fetch_assoc()){
                $tmp[] = $row;
            }
            return $tmp;
        }

    }

    public function execSql($sql,$if_one=false){
        return $this->_query($sql,$if_one);
    }

   /**
    * select execute selection from the db
    * @param  string       $table  table name
    * @param  string|array $where  select condtion for the selection expressed by string or associative array
    * @param  string|array $sort   order condition expressed by string or associative array
    * @param  string       $fields field names you want to pick up
    * @param  boolean      $if_one indicate if the result is one record
    * @return array                result
    */
    public function select($table,$where,$sort,$if_one=false,$cols = "*"){
        if($where){
            $wherestr = " where ";
            if(is_array($where)){
                $index = 0;
                foreach($where as $key => $val){
                    if($index != 0){
                        $wherestr .= " AND";
                    }
                    if(is_string($val)){
                        $wherestr .= $key."='".mysql_real_escape_string($val)."'";
                    }else{
                        $wherestr .= $key."=".$val;
                    }
                    $index++;
                }
            }else{
                $wherestr .= $where;
            }
        }
        if($sort){
            $sortstr = " ORDER BY";
            if(is_array($sort)){
                $index = 0;
                foreach($sort as $key => $val){
                    if($index != 0){
                        $sortstr .= " AND";
                    }
                    $sortstr .= $key."=".$val;
                    $index++;
                }
            }else{
                $sortstr .= $sort;
            }
        }
        $sql = "SELECT ".$cols." FROM ".$table.$wherestr.$sort.";";
        return $this->_query($sql,$if_one);
    }
    public function update($table,$where,$data){
        if($where){
            $wherestr = " where ";
            if(is_array($where)){
                $index = 0;
                foreach($where as $key => $val){
                    if($index != 0){
                        $wherestr .= " AND";
                    }
                    if(is_string($val)){
                        $wherestr .= $key."='".mysql_real_escape_string($val)."'";
                    }else{
                        $wherestr .= $key."=".$val;;
                    }
                    $index++;
                }
            }else{
                $wherestr .= $where;
            }
        }else{
            return false;
        }
        if($data){
            $datastr = " SET ";
            if(is_array($data)){
                $index = 0;
                foreach($data as $key => $val){
                    if($index != 0){
                        $datastr .= " ,";
                    }
                    if(is_string($val)!="now()"){
                        $datastr .= $key."='".mysql_real_escape_string($val)."'";
                    }else{
                        $datastr .= $key."=".$val;
                    }
                    $index++;
                }
            }else{
                $datastr .= $data;
            }
        }else{
            return false;
        }
        $sql = "UPDATE ".$table.$datastr.$wherestr.";";
        $if_one = true;
        return $this->_query($sql,$if_one);
   }
   public function insert($table,$data,$return = false){
        if($data){
            $cols = " (";
            $vals = " (";
            $index = 0;
            foreach($data as $key => $val){
                if($index != 0){
                    $cols .= " ,";
                    $vals .= " ,";
                }
                $cols .= $key;
                if(is_string($val)&&$val!="now()"){
                    $vals .= "'".mysql_real_escape_string($val)."'";
                }else{
                    $vals .=$val;
                }
                $index++;
            }
            $cols .= ") ";
            $vals .= ");";
        }else{
            return false;
        }
        $sql = "INSERT INTO ".$table.$cols." VALUES ".$vals;
        $if_one = true;
        if($this->_query($sql,$if_one)){
            if($return){
                return $this->insert_id;
            }else{
                return true;
            }
        }else{
            return false;
        }
   }

   public function delete($table,$where){
        if($where){
            $wherestr = " where ";
            if(is_array($where)){
                $index = 0;
                foreach($where as $key => $val){
                    if($index != 0){
                        $wherestr .= " AND";
                    }
                    if(is_string($val)){
                        $wherestr .= $key."='".mysql_real_escape_string($val)."'";
                    }else{
                        $wherestr .= $key."=".$val;;
                    }
                    $index++;
                }
            }else{
                $wherestr .= $where;
            }
        }
        $sql = "DELETE FROM ".$table.$wherestr;
        $if_one = true;
        return $this->_query($sql,$if_one);
   }

}