<?php

$pagina=1;
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
  </body>
  <ul class="pagination">
													<li><span class="button disabled">Prev</span></li>
													
										<?php
										for ($i=$pagina; $i <= 5 ; $i++) {  
            
														if ($i==$pagina){ 
               echo "activo";
               $i++;
               echo $i;
               } else { 
															echo "inactivo";
              }
              
															}	?>
														<li><a href="#" class="button">Next</a></li>
             </ul>
              </body>
</html>