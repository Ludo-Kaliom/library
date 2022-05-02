<?php 
// Configuration de la connexion
define('DB_HOST','');
define('DB_USER','');
define('DB_PASS','');
define('DB_NAME','library');

try
{
    // Connexion � la base
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e)
{
	// Echec de la connexion
    exit("Error: " . $e->getMessage());
}
?>
