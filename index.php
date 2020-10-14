<?php

//Cuando se recarga la pag, evalua si se dió clic en algún enlace de la paginación y por ende paso algún elemento por GET
if(!isset($_GET["pagina"])){//Si no que la pagina en la que estamos sea = 1
	$pagina=1;//Guardamos en una var la página en la que nos encontramos
	}else{ //De otra forma que la capture de la URL
		$pagina=$_GET["pagina"];//Guardamos en una var la página en la que nos encontramos
	}

//Guardamos en una var cuantos registros queremos mostrar por página
$tamano_paginas=6;

//Incluimos la conexion
require("app/conection.php");

//Consulta sql para select
$sql="SELECT * FROM post ORDER BY id_post DESC";

$resulset=$conn->query($sql);

//Contamos cuantos registros trae nuestra consulta
$num_filas=$resulset->rowCount();

	
//Para saber la cantidad de paginas de nuestra paginación, y usamos la func ceil para que si da decimal, redondee hacia arriba y nos muestre esos registros sobrantes en una pagina más
$total_paginas=ceil($num_filas/$tamano_paginas);

//Desde dónde empieza
$empezar_desde=($pagina-1)*$tamano_paginas;

//Sentencia sql y utilizamos LIMIT, que es una sentencia sql que limita el número de registros resultado, recibiendo 2 parametros: a partir de cuál registro quieres que se vea, y cuantos a partir de este
$sql_limite="SELECT post.*, admin.user, category.name_cat FROM post left join admin on post.admin_id_admin=admin.id_admin left join category on post.category_id_category=category.id_category
ORDER BY id_post DESC LIMIT $empezar_desde, $tamano_paginas";

//Ejecutamos nuestra consulta y nos devuelve un objeto de tipo resulset
$resulset=$conn->query($sql_limite);

?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>LionSite</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="icon" href="assets/logo_colegio.png" sizes="16x16" type="image/png">
		<style>
			.pagination{
		display: flex;
  justify-content: center;
		display: flex;
  align-items: center;
			}
		</style>
	</head>
	<body class="is-preload">

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

							<!-- Banner -->
								<section id="banner">
									<div class="content">
										<header>
											<h1>Bienvenido<br />
											</h1>
											<p>Somos León XIII :)</p>
										</header>
										<p>Aenean ornare velit lacus, ac varius enim ullamcorper eu. Proin aliquam facilisis Algunos Blogs congue. Integer mollis, nisl amet convallis, porttitor magna ullamcorper, amet egestas mauris. Ut magna finibus nisi nec lacinia. Nam maximus erat id euismod egestas. Pellentesque sapien ac quam. Lorem ipsum dolor sit nullam.</p>
										<ul class="actions">
											<li><a href="generic.html" class="button big">Leer Más</a></li>
										</ul>
									</div>
									<span class="image object">
										<img loading="lazy" src="assets/colegio.jpg" alt="" />
									</span>
								</section>

							<!-- Section -->
								

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
												<img loading="lazy" src="intranet/uploads/<?php echo $registros["archivo"]?>" alt="Imagen: <?php echo $registros["archivo"] ?>" width="100%" />
											<?php } else { ?>
												<img loading="lazy" src="intranet/uploads/generica.png" alt="Sin imagen" width="100%" />
											<?php } ?>
											<h3><?php echo $registros["tittle_post"];?></h3>
											<p><?php echo $registros["content"];?></p>
											<?php
											if($registros["link"]!= NULL){ ?>
											<a href="<?php echo $registros["link"];?>" class="button" target="_blank"> Enlace</a><br><br>
											<?php }?>
											<blockquote>Categoría: <?php echo $registros["name_cat"] . "<br>"; if ($registros["user"]!=NULL) {
												echo "Publicado por: " . $registros["user"] . "<br>";
											} else { echo "Publicado: "; }  echo $registros["date_post"];?> hora colombiana</blockquote>
										</article>
										<?php } ?>
									</div>
										
													<ul class="pagination">
										<?php
										//---------------------------Paginación----------------------------------
										if ($pagina>=2) { ?>
											<li><a href="index?pagina=<?php  echo $pagina-1; ?>" class="button">Anterior</a></li>
										<?php }  else { ?>
											<li><span class="button disabled">Anterior</span></li>
										<?php } ?>

										<?php

										//Utilizamos este ciclo for para que imprima la cantidad de paginas de nuestra paginación
										for ($i=1; $i <= $total_paginas ; $i++) {  
									//Le decimos que recargue la página y además pasamos por GET (? URL) la página que se cliquea
														if ($i==$pagina){ ?>
														<li><a href="index?pagina=<?php echo $i ?>" class="page active"><?php echo $i ?></a></li>
														<?php } else { ?> 	
														<li><a href="index?pagina=<?php  echo $i ?>" class="page"><?php echo $i ?></a></li>
														<?php	
														}
															}	?>
													<?php
														if ($pagina<$total_paginas) { ?>
														<li><a href="index?pagina=<?php  echo $pagina+1; ?>" class="button">Siguiente</a></li>
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
										<li><a href="index">Inicio</a></li>
										<li><a href="about.html">León XIII</a></li>
										<li><a href="presentation.html">QUIENES SOMOS</a></li>
										<li><a href="elements.html">Elements</a></li>
										<li><a href="contacto.html">Contáctenos</a></li>
									</ul>
								</nav>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Algunos Blogs</h2>
									</header>
									<div class="mini-posts">
										<article>
											<a href="#" class="image"><img loading="lazy" src="intranet/images/mat2.PNG" alt="" /></a>
											<p><a href="https://matematicasleon13.jimdofree.com/" target="_blank">Matemáticas</a></p>
										</article>
										<article>
											<a href="#" class="image"><img loading="lazy" src="intranet/images/ed_fis.png" alt="" /></a>
											<p><a href="https://educacionfisicaleonxiii.webnode.es/nosotros/" target="_blank">Ed. Fisica</a></p>
										</article>
										<article>
											<a href="#" class="image"><img loading="lazy" src="intranet/images/mat1.jpg" alt="" /></a>
											<p><a href="https://waltermonsalve.wixsite.com/matematicas" target="_blank">Matemáticas 10 y 11</a></p>
										</article>
									</div>
									<ul class="actions">
										<li><a href="#" class="button">More</a></li>
									</ul>
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
									<a href="app">¿Eres admin?</a>
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