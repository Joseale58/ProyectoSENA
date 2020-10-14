<?php

 $nombre=$_POST["nombre"];
 $origen=$_POST["correo"];
 $destino="lionsitee@gmail.com";
 $asunto=$_POST["asunto"];
 $mensaje="<br><br>" . $_POST["mensaje"];
 $headers="MIME-Version: 1.0\r\n";
 $headers.="Content-type: text/html; charset=iso-8859-1\r\n";
 $headers.="Enviado por: " . $nombre . "\r\n";
 $headers.= $origen;

 $exito=mail($destino,$asunto,$mensaje,$headers);

 if($exito){
  echo "<script>alert('El mensaje ha sido enviado con exito. Gracias $nombre, pronto nos pondremos en contacto contigo');window.location.href='../contacto'</script> ";
 } else {
  echo "<script>alert('Ha ocurrido un error intentalo nuevamente');window.location.href='../contacto'</script> ";
 }
 unset($_POST);
 
?>