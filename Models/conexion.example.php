<?php 


/**
 * 
 */
class Conexion
{
	
	static public function conectar()
	{
		$dbHost = 'yourDBhost';
		$dbName = 'yourDBname';
		$dbUser = 'yourDBuser';
		$dbPass = 'yourDBpassword';
		try {
		    $link = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
		    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $link->exec("set names utf8");
		    
		    return $link;
		} catch(Exception $e) {
		    echo $e->getMessage();
		}
	}
}