<?php
  session_start();
  if (isset($_SESSION['admin'])) {
  require_once 'conection.php'; //Socilita archivo

  require("menu.php");

  $record=null;

  if (!empty($_POST['actualizar'])) {
      $record = $conn->prepare('UPDATE post SET tittle_post=:titulo,content=:contenido,category_id_category=:categoria, link=:enlace WHERE id_post=:id_post');
      $record->bindParam(':id_post', $_POST['id_post']);
      $record->bindParam(':titulo', $_POST['titulo']);
      $record->bindParam(':contenido', $_POST['content']);
      $record->bindParam(':categoria', $_POST['category']);
      $record->bindParam(':enlace', $_POST['enlace']);
      $record->execute();
      if ($record) {
          echo "<p class='btn btn-success'>Su POST se ha actualizado</p>";
  }else{
        echo "<p class='btn btn-danger'>No se puede actualizar, revise su información</p>";
   }
  }

  /*Recuperar los datos*/
  if (isset($_GET['id'])) {
    $id_p=$_GET['id'];
    $result = $conn->prepare('SELECT * FROM post WHERE id_post=:id_post');
    $result->bindParam(':id_post',$id_p);
    $result->execute();

    if ($result->rowCount()>=1) {
      $view = $result->fetch(PDO::FETCH_ASSOC);
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LionSite</title>
 <link rel="icon" href="../assets/logo.ico"> <!--Favicon-->
 <link rel="stylesheet" href="../assets/css/main.css" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <style>
  
  .form{
    width: 50%;
    margin-left: auto;
    margin-right: auto;
  }

  h2{
   text-align: center;
  }

  </style>
  <?php
  require_once 'links.php';
  require_once 'scripts.php';
  ?>

  </head onload="nobackbutton();">
  <body>
    <h2>Actualizar Publicación</h2>
    <!--Formulario para registrar un administrador-->
    <form method="post" action="#" class="form">
      <div class="row gtr-uniform">
       <div class="col-11 col-20-xsmall">
        <label>ID</label>
        <input type="hidden" name="id_post" class="demo-name" value="<?php echo $view['id_post'] ?>"/>
        <input type="text" name="id_post" class="demo-name" value="<?php echo $view['id_post'] ?>" disabled/><br>
        <label>Titulo</label>
        <input type="text" name="titulo" id="demo-name" value="<?php echo $view['tittle_post'] ?>"/><br>
        <label>Contenido de texto</label>
        <textarea name="content" id="demo-message" rows="6"><?php echo $view['content'] ?></textarea><br>
        <label>Categoría</label>
        <select name="category" id="demo-category" required>
         <option value="">- Categoría * -</option>
         <option value="1" <?php echo ($view['category_id_category']==1) ? "selected" : "" ?>>Institucional</option>
         <option value="2" <?php echo ($view['category_id_category']==2) ? "selected" : "" ?>>Deportes</option>
         <option value="3" <?php echo ($view['category_id_category']==3) ? "selected" : "" ?> >Gobierno</option>
         <option value="4" <?php echo ($view['category_id_category']==4) ? "selected" : "" ?>>Horario</option>
         <option value="5" <?php echo ($view['category_id_category']==5) ? "selected" : "" ?>>Otro</option>
       </select><br>
       <label>Enlace</label>
       <input type="text" name="enlace" id="demo-name" value="<?php echo $view['link'] ?>"/><br> 
       <input type="submit" name="actualizar" value="Actualizar">
       <br><br>
       <a href="home?page=admin_view" class="btn btn-primary">Volver</a>
     </div>
   </form>

  </body>
  </html>
  <?php
} else {
  header("location:index");
}
?>