<?php
	require 'conection.php';
	session_start(); //sesiones de usuario
	if (isset($_SESSION['admin'])) {
		$record = $conn->prepare('DELETE FROM admin WHERE pass=:pass');
		$record->bindParam(':pass',$_GET['pass']);
		$record->execute();
		if($record){
			header('location: admin_view');
		}else {
			echo "Error no se eliminó";
		}
	}else{
		header('location: ./');
	}			
?>

