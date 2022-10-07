<?php 
//mysql_connect('192.168.166.3', 'b3l4j4r', '1899b3l4j4rp455');
//mysql_connect('localhost', 'b3l4j4r', '1899b3l4j4rp455');
//mysql_select_db('belajar_rumah');

include 'database.class.php';
//mysql_connect('localhost', 'root', '');
//mysql_select_db('belajar_rumah');
$alamatdata="../file_storage/";
define("DB_HOST", "localhost");
define("DB_USER", "b3l4j4r");
define("DB_PASS", "1899b3l4j4rp455");
define("DB_NAME", "belajar_rumah");
$database = new Database();
?>