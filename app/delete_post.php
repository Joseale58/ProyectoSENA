<?php

 //Archivo para eliminar POSTS

 //Requerimos las conexion PDO
 require("conection.php");

 //Capturamos elemento Id por la barra de búsqueda
 $id=$_GET["id"];

 //Consulta SQL para eliminar
 $sql="DELETE FROM post WHERE id_post='$id'";

 //Ejecutamos la consulta y nos devuelve un archivo PDOstatmente
 $conn->query($sql);

 //Redireccionamos al index donde si no hay error ya aparecerá el registro
 header('Location:index.php')




?>