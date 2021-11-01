<?php
require_once 'clases/Usuario.php';
require_once 'clases/ControladorSesion.php';
session_start();

if (isset($_SESSION['usuario'])) {
  $usuario = unserialize($_SESSION['usuario']);
  $nomApe = $usuario->getNombreApellido();
  $id = $usuario->getId();
} else {
  header('Location: index.php');
}



if (isset($_POST['nombre_cancion']) && isset($_POST['genero']) && isset($_POST['artista'])) {
    $cs = new ControladorSesion(); 
    $result = $cs->añadirCancion($_POST['userID'], $_POST['nombre_cancion'],  $_POST['genero'], $_POST['artista']);
    if( $result[0] === true ) {
        $redirigir = 'agregarCancion.php?mensaje='.$result[1];
    }
    else {
        $redirigir = 'agregarCancion.php?mensaje='.$result[1];
    }
    header('Location: ' . $redirigir);
}
?>

<!DOCTYPE html> 
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Cancion</title>
        <link href="style.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="content_login" background="background.png">
      <div class="content_title_login">
      Agregar Nueva Cancion
      </div>         <?php
            if (isset($_GET['mensaje'])) {
                echo '<div id="mensaje" class="error">
                    <p  style="color:white">'.$_GET['mensaje'].'</p></div>';
            }
        ?>   
      <div class="content_title_login">

        <form action="agregarCancion.php" method="post">

          <div class="content_input_login">
            <input name="userID" type="hidden" value=<?php echo $id ?>><br>
          </div>

          <div class="content_input_login">
            <input name="nombre_cancion" placeholder="Cancion" required><br>
          </div>

          <div class="content_input_login">
            <input name="genero" placeholder="Genero" required><br>
          </div>

          <div class="content_input_login">
            <input name="artista" placeholder="Artista" required><br>
          </div>
          
          <div style="text-align:center"> 
            <input type="submit" value="Añadir" class="btn2"> 
          </div>

        </form>   
        

      </div>
      <br>
        <div class="">
          <a href="home.php" class="btn2">Volver al Home</a>
        </div>
    </body>
</html>