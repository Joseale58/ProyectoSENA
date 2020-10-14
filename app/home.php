<?php
	//sesiones de usuario
	require_once 'conection.php';
	session_start();
	if (isset($_SESSION['admin'])) {
		$Buscar=$conn->prepare('SELECT * FROM admin WHERE id_admin=:idadm');
		$Buscar->bindParam(':idadm',$_SESSION['admin']);
		$Buscar->execute();
		$results=$Buscar->fetch(PDO::FETCH_ASSOC);
		$user = null;
		if (count($results)>0) {
			$user=$results;
		}
		//Cuando se recarga la pag, evalua si se dió clic en algún enlace de la paginación y por ende paso algún elemento por GET
	if(!isset($_GET["pag"])){//Si no que la pagina en la que estamos sea = 1
		$pag=1;//Guardamos en una var la página en la que nos encontramos
		}else{ //De otra forma que la capture de la URL
			$pag=$_GET["pag"];//Guardamos en una var la página en la que nos encontramos
		}

	//Guardamos en una var cuantos registros queremos mostrar por página
	$tamano_paginas=6;

	//Consulta sql para select
	$sql="SELECT * FROM post ORDER BY id_post DESC";

	$resulset=$conn->query($sql);

	//Contamos cuantos registros trae nuestra consulta
	$num_filas=$resulset->rowCount();

		
	//Para saber la cantidad de paginas de nuestra paginación, y usamos la func ceil para que si da decimal, redondee hacia arriba y nos muestre esos registros sobrantes en una pagina más
	$total_paginas=ceil($num_filas/$tamano_paginas);

	//Desde dónde empieza
	$empezar_desde=($pag-1)*$tamano_paginas;

	//Sentencia sql y utilizamos LIMIT, que es una sentencia sql que limita el número de registros resultado, recibiendo 2 parametros: a partir de cuál registro quieres que se vea, y cuantos a partir de este
	$sql_limite="SELECT post.*, admin.user, category.name_cat FROM post left join admin on post.admin_id_admin=admin.id_admin left join category on post.category_id_category=category.id_category
	ORDER BY id_post DESC LIMIT $empezar_desde, $tamano_paginas";

	//Ejecutamos nuestra consulta y nos devuelve un objeto de tipo resulset
	$resulset=$conn->query($sql_limite);
?>

<!DOCTYPE html>
<html>
<head>
		<title>LionSite</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
		<link rel="icon" href="assets/logo_colegio.png" sizes="16x16" type="image/png">
		<style>
			.pagination{
				display: flex;
				justify-content: center;
				display: flex;
				align-items: center;
			}
		</style>
	
	<?php
  require_once 'links.php';
  require_once 'scripts.php';
?>
 
</head>
<body class="is-preload">
	<?php
		if(!empty($user)){

		require_once 'menu.php';	

	?>

	<?php
		echo "<h2>Bienvenido: " . "<strong><kbd>" . $user['user'] . "</strong>" . "</h2>";

	?>


	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<!-- Header -->
				<header id="header">
					<a href="index" class="logo"><strong>LionSite</strong> I.E. León XIII</a>
					<ul class="icons">
						<li><a href="https://www.facebook.com/ieleonxiii1912" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
						<li><a href="https://instagram.com/comunicacionesleonxiii?igshid=1824x058w4zkf" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
					</ul>
				</header>


				<!-- Section -->
				<section>
					<header class="major">
						<h2>Nuevo POST</h2>
					</header>
					<form method="post" action="new_post.php" enctype="multipart/form-data" autocomplete="off">
						<div class="row gtr-uniform">
							<div class="col-6 col-12-xsmall">
								<input type="text" name="title" id="demo-name"  placeholder="Titulo *" required/>
							</div>
							<!-- Break -->
							<div class="col-12">
								<select name="category" id="demo-category" required>
									<option value="">- Categoría * -</option>
									<option value="1">Institucional</option>
									<option value="2">Deportes</option>
									<option value="3">Gobierno</option>
									<option value="4">Horario</option>
									<option value="5">Otro</option>
								</select>
							</div>
							<!-- Break -->
							<div class="col-12">
								<textarea name="content" id="demo-message" placeholder="Ingrese acá, su contenido de texto (Opcional)" rows="6"></textarea>
							</div>
							<div class="col-6 col-12-xsmall">
								<input type="text" name="link" id="demo-name"  placeholder="Enlace (Opcional) https://"/>
							</div>
							<div>
								<label for="files">Seleccione una imagen (Opcional Máx 2MB)&nbsp;<input type="file" name="imagen" id="imagen"></input></label>
							</div>
							<div class="col-6 col-12-small">
								<input type="checkbox" id="demo-copy" name="anonimo">
								<label for="demo-copy">Publicar como anónimo</label>
							</div>
							<!-- Break -->
							<div class="col-12">
								<ul class="actions">
									<li><input type="submit" value="Publicar" onclick="return confirm('¿Estas seguro que deseas hacer este post?\n')" class="primary"></li>
									<li><input type="reset" value="Limpiar" /></li>
								</ul>
							</div>
						</div>
					</form>
				</section>
				

				<!-- Section -->
				<section>
					<header class="major">
						<h2>Últimas Publicaciones</h2>
					</header>	
					<div class="posts">
						<?php
						while($registros=$resulset->fetch(PDO::FETCH_ASSOC)){ ?>
							<article>
								<?php
								if ($registros["archivo"]!=NULL) { ?>
									<img loading="lazy" src="../intranet/uploads/<?php echo $registros["archivo"]?>" alt="Imagen: <?php echo $registros["archivo"] ?>" width="100%" />
								<?php } else { ?>
									<img loading="lazy" src="../intranet/uploads/generica.PNG" alt="Sin imagen" width="100%" />
								<?php } ?>
								<h3><?php echo $registros["tittle_post"];?></h3>
								<p><?php echo $registros["content"];?></p>
								<?php
								if($registros["link"]!= NULL){ ?>
									<a href="<?php echo $registros["link"];?>" class="button" target="_blank"> Enlace</a><br><br>
								<?php }?>
								<ul class="alt">
									<blockquote>Categoría: <?php echo $registros["name_cat"] . "<br>"; if ($registros["user"]!=NULL) {
										echo "Publicado por: " . $registros["user"] . "<br>";
									} else { echo "Publicado: "; }  echo $registros["date_post"];?> hora colombiana</blockquote>
									<a href="update_post?id=<?php echo $registros["id_post"]?>" type="button" class="btn btn-warning" onclick="return confirm('¿Estas seguro que desea actualizar el post \' \n <?php echo $registros['tittle_post']; ?>\'?');">Editar</a>
									<a href="delete_post?id=<?php echo $registros["id_post"]?>" type="button" class="btn btn-danger" onclick="return confirm('¿Estas seguro que desea eliminar el post \' \n <?php echo $registros['tittle_post']; ?>\'?');"> Eliminar</a>
								</article>
							<?php } ?>
						</div> 
						<ul class="pagination">
							<?php
							//---------------------------Paginación----------------------------------
							if ($pag>=2) { 
								?>
								<li><a href="home?pag=<?php  echo $pag-1; ?>" class="button">Anterior</a></li>
							<?php }  else { ?>
								<li><span class="button disabled">Anterior</span></li>
							<?php } ?>

							<?php

							//Utilizamos este ciclo for para que imprima la cantidad de paginas de nuestra paginación
							for ($i=1; $i <= $total_paginas ; $i++) {  
						//Le decimos que recargue la página y además pasamos por GET (? URL) la página que se cliquea
								if ($i==$pag){ ?>
									<li><a href="home?pag=<?php echo $i ?>" class="page active"><?php echo $i ?></a></li>
								<?php } else { ?> 	
									<li><a href="home?pag=<?php  echo $i ?>" class="page"><?php echo $i ?></a></li>
									<?php	
								}
							}	?>
							<?php
							if ($pag<$total_paginas) { ?>

								<li><a href="home?pag=<?php  echo $pag+1; ?>" class="button">Siguiente</a></li>
							<?php }  else { ?>
								<li><span class="button disabled">Siguiente</span></li>
							<?php } ?>
						</ul>
					</section> 
				</div>
			</div>

			
			<!-- Sidebar -->
			<div id="sidebar">
				<div class="inner">
					<!-- Menú -->
					<nav id="Menú">
						<header class="major">
							<h2>Menú</h2>
						</header>
						<ul>
							<li><a href="home">Inicio</a></li>
							<li><a href="about">León XIII</a></li>
							<li><a href="presentation">QUIENES SOMOS</a></li>
							<li><a href="elements">Elements</a></li>
							<li><a href="contacto">Contáctenos</a></li>
						</ul>
					</nav>

					<!-- Section -->
					<section>
						<header class="major">
							<h2>Algunos Blogs</h2>
						</header>
						<div class="mini-posts">
							<article>
								<a href="#" class="image"><img loading="lazy" src="../intranet/images/mat2.PNG" alt="" /></a>
								<p><a href="https://matematicasleon13.jimdofree.com/" target="_blank">Matemáticas</a></p>
							</article>
							<article>
								<a href="#" class="image"><img  loading="lazy" src="../intranet/images/ed_fis.png" alt="" /></a>
								<p><a href="https://educacionfisicaleonxiii.webnode.es/nosotros/" target="_blank">Ed. Fisica</a></p>
							</article>
							<article>
								<a href="#" class="image"><img  loading="lazy" src="../intranet/images/mat1.jpg" alt="" /></a>
								<p><a href="https://waltermonsalve.wixsite.com/matematicas" target="_blank">Matemáticas 10 y 11</a></p>
							</article>
						</div>
					</section>

					<!-- Section -->
					<section>
						<header class="major">
							<h2>Contáctenos</h2>
						</header>
						<p>Somos una institución pública ubicada en el municipio de El Peñol, Antioquia.                       Somos un Colegio digital.                   </p>
						<ul class="contact">
							<li class="icon solid fa-envelope"><a href="#">ieleonxiii1912@yahoo.es</a></li>
							<li class="icon solid fa-phone">(4) 8515716</li>
							<li class="icon solid fa-home"> TV 6 A 22 20, Peñol, Antioquia</li>
						</ul>
					</section>

					<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; Untitled. All rights reserved. Demo Images: <a href="https://unsplash.com">Unsplash</a>. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
					</footer>

				</div>
			</div>

		</div>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

	</body>
	</html>
	<?php
}
}else{
	header('location: ./');
}
?>



