<?php
require_once 'clases/Usuario.php';
require_once 'clases/Repositoriocancion.php';
require_once 'clases/CancionFavorita.php';

session_start();

if (isset($_SESSION['usuario'])) {
  $usuario = unserialize($_SESSION['usuario']);
  $nomApe = $usuario->getNombreApellido();
  $rc = new RepositorioCancion();
  $canciones = $rc->get_all($usuario);
} else {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body background="background.png">
  <div class="content_login">
    <div class="content_title_login">
      Mi lista de canciones favoritas
    </div>  
    <br>
    <div class="jumbotron text-center">
    <div style="text-align:center">
      <div class="header-home" style="color:white">  Bienvenido <?php echo $nomApe; ?>   </div>
      <div class="header-home"> <a href="agregarCancion.php" class="btn btn-primary">Ingresar nueva cancion</a></div>
      <div class="header-home"> <a class="btn btn-primary" href="logout.php">Cerrar sesión</a></div>
    </div>
    </div>
    
      <table class='tabla' border='1' style="border-collapse: collapse" bordercolor="#111111">
          <tr>
              <th>N° de cancion </th><th>Cancion</th><th>Genero</th><th>Artista</th><th>Editar</th><th>Eliminar</th>
          </tr>
    <?php
      if (count($canciones) == 0) {
          echo "<tr><td colspan='5'>No tiene canciones creadas</td></tr>";
      } else {
          foreach ($canciones as $unaCancion) {
              $id = $unaCancion->getId();
              echo '<tr>';
              echo "<td>$id</td>";
              echo "<td id='nombre_cancion-$id'>".$unaCancion->getNombreCancion()."</td>";
              echo "<td>".$unaCancion->getGenero()."</td>";
              echo "<td>".$unaCancion->getArtista()."</td>";
              echo "<td><button type='button' onclick='edicionNombreCancion($id)'>Editar</button></td>";
              echo "<td><button type='button'><a href='eliminar.php?id=$id'>Eliminar</a></button>
              </td>";
              echo '</tr>';
          }
      }
    ?>
      </table>
      <br>
      <div id="editar">
                <h3 class="edit">Editar nombre de la cancion</h3> 
                <input type="hidden" id="editar">
                <input type="hidden" id="numeroCancion">
                <label for="cancion" class="new-name">Nombre nuevo: </label>
                <input type="text" id="cancion">
                <button type="button" onclick="editar();" class="btn2">Cambiar nombre</button>
            </div>
            <br>
          </div>
    <script>
        function editar()  { // operacion();
                var editar = document.querySelector('#editar').value;
                var numeroCancion = document.querySelector('#numeroCancion').value;
                var cancion/* monto*/  = document.querySelector('#cancion').value;
                var cadena = "editar="+editar+"&numeroCancion="+numeroCancion+"&cancion="+cancion;
    
                var solicitud = new XMLHttpRequest();
          
                solicitud.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var respuesta = JSON.parse(this.responseText);
                        var identificador = "#nombre_cancion-" + respuesta.id;
                        var celda = document.querySelector(identificador);
    
                        if(respuesta.resultado == "OK") {
                            celda.innerHTML = respuesta.cancion;
                          } else {
                            alert(respuesta.resultado);
                        }
                        celda.scrollIntoView();
                      }
                    };
                    
                    // solicitud.onload = function () {
                    //   console.log(this.responseText)
                    // }
                    solicitud.open("POST", "editar.php?id="+numeroCancion);
                    solicitud.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    solicitud.send(cadena);

        }
        function edicionNombreCancion(nroCancion)
            {
                document.querySelector('#editar').value = "e";
                document.querySelector('#numeroCancion').value = nroCancion;
                document.querySelector('#cancion').focus();
            }      
            
    
    </script>
  </div>
</body>
</html>