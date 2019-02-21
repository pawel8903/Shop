<?php 
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_NAME','sklep');
define('DB_PASS','');


$mysqli = new mysqli(DB_SERVER,DB_USERNAME,DB_PASS,DB_NAME);
// do sprawdzenia błędów w query
/*if(!$stmt){
trigger_error('Inaviled query'.$mysqli->error);
        }
*/
$mysqli->set_charset("utf8");
?>