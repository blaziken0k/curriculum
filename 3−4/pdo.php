<?php
define('DB_DATABASE', 'checktest4');
define('DB_USERNANE', 'root');
define('DB_PASSWORD', 'root');
define('PDO_DSN', 'mysql:host=localhost;charset=utf8;dbname='. DB_DATABASE);

function connect() {

	try {
		$pdo = new PDO(PDO_DSN, DB_USERNANE, DB_PASSWORD);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	} catch (PDOException $e) {
		echo 'Error: ' . $e->getMessage();
		die();
	}
}
 ?>