<?php

	require_once 'conection.php';
	session_start();
    if (isset($_SESSION['admin'])) {
      header('Location:home');
    }


	if(isset($_POST['ingresar'])){
		if (!empty($_POST['user']) && !empty(['pass'])){
			//Comprobación de datos
			$cadena = $_POST['user'];
			$cadena = trim($cadena);//Elimina espacios en blanco
			$cadena = stripslashes($cadena); //Elimina barras invertidas
			$_POST['user'] = $cadena;

			$cadena = $_POST['pass'];
			$cadena = trim($cadena);//Elimina espacios en blanco
			$cadena = stripslashes($cadena); //Elimina barras invertidas
			$_POST['pass'] = $cadena;

			$Buscar=$conn->prepare('SELECT * FROM admin WHERE user=:user');
			$Buscar->bindParam(':user',$_POST['user']);
			$Buscar->execute();
			$Buscar->rowCount();
			$result=$Buscar->fetch(PDO::FETCH_ASSOC);
			/*comprobar si el usuario digitado está en la bd y si la contraseña es correcta*/
			if($_POST['user']==$result['user']){
		        if($result > 0 && password_verify($_POST['pass'], $result['pass'])) {
					$_SESSION['admin'] = $result['id_admin'];
					header('location: home');
				}else{
					$message='La contraseña es incorrecta';		
				}
			}else{
				$message='El usuario no existe';
		    }
		}
	}


	?>
<!DOCTYPE html>
<html>
<head>
<?php
require_once 'links.php';
require_once 'scripts.php';
?>
<style type="text/css">
	a{
		color: #fff;
	}

	#div{
		margin-top: 15px;
	}

	body{
		background: url(../assets/colegio.jpg)no-repeat center center fixed;
		background-size: cover;
	}

	h2{
		color: #fff;
		-webkit-text-stroke: 0.5px #000;
	}

	#user{
		margin-top: 20px;
		margin-bottom: 10px
	}

	#main{
		margin:0 auto;
		margin-top: 25%;
		padding: 0;
	}

	.modal-content{
		background-color: #2980b9;
		padding: 0 20px;
	}

	.form-group input{
		height: 40px;
		font-size: 18px;
		border: 1;
		padding-left: 35px;

	}

	.form-group::before{
		font-family: "Font awesome\ 5 free";
		position: absolute;
		left: 24px;
		font-size: 18px;
		padding-top: 6px;
	}

	.form-group#user::before{
		content: "\f007";
	}

	.form-group#pass::before{
		content: "\f023";
	}

	#submit{
		margin-bottom: 20px;
	}

</style>
</head>
<body onload="nobackbutton();">

	<?php
	if (!empty($message)) {

		echo "<h4>". $message ."</h4>";
	}
	?>
	<!--Formulario para registrar un administrador-->
	<div class="modal-dialog text-center" >

		<div class="col-sm-8" id="main">
			<div class="modal-content">
				<h2>Inicio sesión</h2>

				<form action="" method="post" class="col-12" enctype="multipart/form-data" autocomplete="off">
					<div class="form-group" id="user">
						<input type="text" class="form-control" id="fname" name="user" placeholder="Usuario"><br>
					</div>
					<div class="form-group" id="pass">

						<input type="password" class="form-control" id="lname" name="pass" placeholder="Contraseña"><br>
					</div>
					<div class="checkbox">
						<button class="btn btn-success" id="submit" name='ingresar'><i class="fas fa-sign-in-alt"></i>  Ingresar</button>
					</div>
					<a href="../" class="btn btn-warning"><i class="fas fa-arrow-alt-circle-left"></i> Regresar</a>
				</form> 
			</div>
		</div>

	</div>
</body>
</html>