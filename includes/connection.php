<?php 

$host = 'localhost';
$user = 'root';
$password = '';
$name = 'netmate';

$con = mysqli_connect($host, $user, $password, $name);

if (!$con) {
	die('Conneciton to the database failed').mysqli_error();
}


?>
