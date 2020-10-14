<?php
  session_start();
  if (isset($_SESSION['admin'])) {
  require_once 'conection.php'; //Socilita archivo
  $message=null;
  $record=null;

  if (!empty($_POST['actualizar'])) {
    /*Comprobar al cambiar el usuario si existe en la db*/
    if($_POST['user1']!=$_POST['user2']){
      $record=$conn->prepare("SELECT * FROM admin WHERE user=:user");
      $record->bindParam(":user",$_POST['user2']);
      $record->execute();
      if($record->rowCount()>=1){
        $message="<br>El usuario ya esta registrado";
        $userf=$_POST['user1'];
      }else{
        $userf=$_POST['user2'];
      }
    }else{
      $userf=$_POST['user1'];
    }
    /*Comprobar contraseñas*/
    if(empty($_POST['pass1']) && empty($_POST['pass2'])){
      $record = $conn->prepare('UPDATE admin SET nombre=:nombre,apellido=:apellido,user=:user WHERE id_admin=:id_admin');
      $record->bindParam(':id_admin', $_POST['id_admin']);
      $record->bindParam(':nombre', $_POST['nombre']);
      $record->bindParam(':apellido', $_POST['apellido']);
      $record->bindParam(':user', $userf);
      $record->execute();
    }elseif ($_POST['pass1']!="" && $_POST['pass2']!="" && $_POST['pass1']==$_POST['pass2']){
        $record = $conn->prepare('UPDATE admin SET nombre=:nombre,apellido=:apellido,user=:user,pass=:pass2 WHERE id_admin=:id_admin');
        $record->bindParam(':id_admin', $_POST['id_admin']);
        $record->bindParam(':nombre', $_POST['nombre']);
        $record->bindParam(':apellido', $_POST['apellido']);
        $record->bindParam(':user', $userf);
        $password=password_hash($_POST['pass2'], PASSWORD_BCRYPT);
        $record->bindParam(':pass2',$password);
        $record->execute();
      }else{
        echo "<br><br> Las claves no coinciden - "; 
      }
      if ($record) {
        if(!empty($message)) {
          echo $message;        
        }else{
          echo "<br> Datos actualizados";
        }
      }else{
        echo " No se puede actualizar, revise su información";
      }
    }
    /*Recuperar los datos*/
      if (isset($_GET['id_admin'])) {
        $id_a=$_GET['id_admin'];
        $result = $conn->prepare('SELECT * FROM admin WHERE id_admin=:id_admin');
        $result->bindParam(':id_admin',$id_a);
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <?php
        require_once 'links.php';
        require_once 'scripts.php';
      ?>

      </head onload="nobackbutton();">
      <body>
        <h2>Actualizar Administrador</h2>
        <!--Formulario para registrar un administrador-->
      <form action="" method="post" enctype="multipart/form-data">
        <label>ID</label><br>
        <input type="hidden" name="id_admin" value="<?php echo $view['id_admin'] ?>">
        <input type="number" name="id" value="<?php echo $view['id_admin'] ?>" disabled=""><br>
        <label>Nombre</label><br>
        <input type="text" name="nombre" value="<?php echo $view['nombre'] ?>"><br>
        <label>Apellido<br>
        <input type="text" name="apellido" value="<?php echo $view['apellido'] ?>"><br>
        <label>Usuario</label><br>
        <input type="hidden" name="user1" value="<?php echo $view['user'] ?>">
        <input type="text" name="user2" value="<?php echo $view['user'] ?>"><br>
        <label>Correo</label><br>
        <input type="email" name="email" value="<?php echo $view['email'] ?>"><br>
        <label>Contraseña</label><br>
        <input type="password" name="pass1" ><br>
        <label>Confirmar contraseña</label><br>
        <input type="password" name="pass2" ><br><br>
        <input type="submit" name="actualizar" value="Actualizar">
        <br><br>
        <a href="home?page=admin_view">Volver</a>
      </form> 

      </body>
    </html>
    <?php
      } else {
        header("location:index");
      }
?>