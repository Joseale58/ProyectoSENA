<?php
  require_once 'conection.php';
  session_start();
  if (isset($_SESSION['admin'])) {
  require_once 'conection.php';
  require ("menu.php");
  if (isset($_POST['guardar'])) {
    if ($_POST['pass']==$_POST['pass2']){
    $record=$conn->prepare('INSERT INTO admin(nombre,apellido,user,email,pass) VALUES (:nombre, :apellido, :user, :email, :pass)');
    $record->bindParam(':nombre',$_POST['nombre']);
    $record->bindParam(':apellido',$_POST['apellido']);
    $record->bindParam(':user',$_POST['user']);
    $record->bindParam(':email',$_POST['email']);
    $password=password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $record->bindParam(':pass',$password);
      if ($record->execute()) {
    
        echo "<div class='alert alert-success'>" . " Administrador Creado" . "</div>";
    
      }else{
        echo "<div class='alert alert-danger'><p>" . "Administrador No Creado, revise la información digitada" . "</p></div>";
      }
    } else {
      echo "<div class='alert alert-danger'><p>" . "Administrador No Creado, verifique que las contraseñas coincidan" . "</p></div>";
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

  <div class="container">
    <!-- Button to Open the Modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Crear Administrador
  </button>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Nuevo Administrador</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label>Nombre</label><br>
                <input type="text" class="form-control" id="fname" name="nombre" placeholder="Nombre"><br>
              </div>
              <div class="form-group">
                <label>Apellido<br>
                <input type="text" class="form-control" id="lname" name="apellido" placeholder="Apellido"><br>
              </div>
              <div class="form-group">
                <label>Usuario</label><br>
                <input type="text" class="form-control" id="fname" name="user" placeholder="usuario"><br>
              </div>
              <div class="form-group">
                <label>Correo</label><br>
                <input type="email" class="form-control" id="lname" name="email" placeholder="Correo electrónico"><br>
              </div>
              <div class="form-group">
                <label>Contraseña</label><br>
                <input type="password" class="form-control" id="lname" name="pass" placeholder="Contraseña"><br><br>
              </div>
              <div class="form-group">
                <label>Confirme contraseña</label><br>
                <input type="password" class="form-control" id="lname" name="pass2" placeholder="Contraseña"><br><br>
              </div>
              <button type="submit" class="btn btn-primary" name="guardar">Guardar</button> 
              <br>
              
          </form> 

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        </div>

      </div>
    </div>
  </div>
  </div>



  </body>
  </html>

  <?php
  }
  else {
    header('location: ./');
  }
?>

     


