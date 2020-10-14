<?php

  require_once 'conection.php';

      //Capturar fecha

  date_default_timezone_set("America/Bogota"); 

  $fecha=date("Y-m-d H:i:s");

  //Capturamos el admin, o lo dejamos como anonimo
  if (isset($_POST["anonimo"])) { 
    $autor=NULL; 
  } else {
    session_start();
    $autor=$_SESSION['admin'];
  }   
      //Capturamos imagen

     $nombre_imagen=$_FILES["imagen"]["name"]; //Para saber el nombre del archivo

     $tipo_imagen=$_FILES["imagen"]["type"]; //Para saber el tipo del documento

     $tamano_imagen=$_FILES["imagen"]["size"]; //Para saber el tamaño del documento

     /*Dirección para guardar definitivamente los documentos*/
     $carpeta_definitiva=$_SERVER["DOCUMENT_ROOT"]. "/intranet/uploads/";
      
   
     
  //Validacion imagen; tamaño
  if (isset($nombre_imagen) && $tamano_imagen<=2000000) {

  //Validación para formato 
   if ($tipo_imagen=="image/jpeg" || $tipo_imagen=="image/jpg" || $tipo_imagen=="image/png" || $tipo_imagen=="image/gif"){


  //Función para transportar el documento a la carpeta definitiva desde la carpeta temporal, y si es posible imprimeme esto
     if(move_uploaded_file($_FILES["imagen"]["tmp_name"],$carpeta_definitiva.$nombre_imagen)){
        //echo "Su archivo ha sido enviado desde la carpeta temporal: " . $_FILES["imagen"]["tmp_name"] . " a la carpeta definitiva: " . $carpeta_definitiva.$nombre_imagen;
        } else { //si no
        //echo "Fallo al enviar archivo a la carpeta final, ERROR: " . $tamano_imagen=$_FILES["imagen"]["error"];
        echo "<script>alert('Fallo')</script>";
        }
          } else {

            echo "<script>alert('Solo permitidas imagenes png,jpg,jpeg, y gif')</script>";
          }
            } else if (isset ($tamano_imagen)) {

              echo "<script>alert('El archivo excede el tamaño maximo permitido');window.location.href='home'</script>";
              exit();
     }



  $record=$conn->prepare('INSERT INTO post(tittle_post,content, category_id_category,admin_id_admin, link, date_post, archivo) VALUES (:titulo, :contenido, :categoria, :autor, :enlace, :fecha, :archivo)');
  $record->bindParam(':titulo',$_POST['title']);
  $record->bindParam(':contenido',$_POST['content']);
  $record->bindParam(':categoria',$_POST['category']);
  $record->bindParam(':autor',$autor);
  $record->bindParam(':enlace',$_POST['link']);
  $record->bindParam(':fecha',$fecha);
  $record->bindParam(':archivo',$nombre_imagen);

  if ($record->execute()) {

   echo "<script>alert('El post se ha publicado');window.location.href='home'</script> ";

  }else{

   echo "<script>alert('El post NO se ha publicado');window.location.href='home'</script> ";

  }

?>