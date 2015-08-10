<?php
define("APP_ID","1465764250389981");
define("APP_SECRET","5729f9252bf20c8b96d888fabc28eedb");
define("MOVIE_NAME_KEY","2");
define("SALES_KEY","4");
define("TOTAL_SALES_KEY","9");
define("TARGET_TR","table:nth-of-type(3) td table tr");
define("SOURCE_URL","http://www.boxofficemojo.com/weekend/chart/");
define("TARGET_DOC_ROOT","http://www.boxofficemojo.com");
define("TITLE_KEY","1");

class constants{
    public static $months = array(
    "January" => 1,
    "February" => 2,
    "March" => 3,
    "April" => 4,
    "May" => 5,
    "June" => 6,
    "July" => 7,
    "August" => 8,
    "September" => 9,
    "October" => 10,
    "November" => 11,
    "December" => 12
    );
    public static $permissions = array(
        "scope"=>"user_birthday,user_hometown"
    );
}
