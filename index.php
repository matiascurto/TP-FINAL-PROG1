<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Pagina de Inicio</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body background="background.png">
  <div class="content_login">
    <div class="content_title_login">
      Lista de Canciones favoritas
    </div>
    <div class="content_login_form">
      <div class="title_form_log">
        Ingrese su usuario para hacer una lista de sus canciones favoritas
      </div>
      <form action="login.php" method="post">
        <div class="content_input_login">
          <input type="text" name="usuario" placeholder="Usuario">
        </div>
        <div class="content_input_login">
          <input type="password" name="clave" placeholder="Contraseña">
        </div>

        <?php
            if (isset($_GET['mensaje'])) {
                echo '<div id="mensaje" class="alert alert-primary text-center">
                    <p>'.$_GET['mensaje'].'</p></div>';
            }
        ?>

        <div class="content_btns_login">
          <a href="create.php" class="btn_login_registrarse">
            Registrarse
          </a>
          <input class="btn_login_iniciar" type="submit" value="Ingresar" />
        </div>
      </form>
    </div>
  </div>
</body>

</html>
