<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bd_sitio";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Conexión OK";
} catch(PDOException $e) {
  echo "Fallo al conectar. " . $e->getMessage();
}
?>