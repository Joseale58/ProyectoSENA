<?php
	//sesiones de usuario
	require_once 'conection.php';
	session_start();
	if (isset($_SESSION['admin'])) {
	require("menu.php");
	$Buscar=$conn->prepare('SELECT * FROM admin WHERE id_admin=:idadm');
	$Buscar->bindParam(':idadm',$_SESSION['admin']);
	$Buscar->execute();
	$results=$Buscar->fetch(PDO::FETCH_ASSOC);
	$user = null;

	if (count($results)>0) {
		$user=$results;
		}
	?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<title>LionSite</title>
	<link rel="icon" href="../assets/logo.ico"> <!--Favicon-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php
	require_once 'links.php';
	require_once 'scripts.php';
	?>

	</head>
	<body>
	<?php if(!empty($user)){ ?>
		<!-- Mostrar adm-->

		<div class="container">
		<h2>TABLA ADMINISTRADORES</h2>           
		<table class="table">
			<thead>
				<tr>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Correo</th>
					<th>Usuario</th>
					<th>Operaciones</th>
				</tr>
			</thead>

			<?php
			$result = $conn->prepare('SELECT * FROM admin WHERE id_admin!=:idadm AND id_admin!=1');
			$result->bindParam(':idadm',$_SESSION['admin']);
			$result->execute();
			while($view = $result->fetch(PDO::FETCH_ASSOC)) {
				?>
				<tr>
					<td><?php echo $view['nombre']; ?></td>
					<td><?php echo $view['apellido']; ?></td>
					<td><?php echo $view['email']; ?></td>
					<td><?php echo $view['user']; ?></td>
					<td><a href="admin_update?id_admin=<?php echo $view['id_admin']; ?>" onclick="return confirm('¿Estas seguro que desea actualizar el registro con id_admin?\n <?php echo $view['id_admin']; ?>');">Actualizar/</a><a href="admin_delete?pass=<?php echo $view['pass']; ?>" onclick="return confirm('¿Estas seguro que desea eliminar el registro con id_admin?\n <?php echo $view['id_admin']; ?>');">Eliminar</a></td>
				</tr>
			<?php } ?>

		</table>
		</div>

	</body>
	</html>
			<?php 
		}
	}else{
		header('location: ./');
}
?>

