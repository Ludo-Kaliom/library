<?php 
// DB credentials.
define('DB_HOST','');
define('DB_USER','');
define('DB_PASS','');
define('DB_NAME','library');
// Establish database connection.
try
{
    //$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e)
{
    exit("Error: " . $e->getMessage());
}
?>
