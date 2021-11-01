<?php
require_once 'clases/Usuario.php';
require_once 'clases/RepositorioCancion.php';
require_once 'clases/RepositorioUsuario.php';
require_once 'clases/CancionFavorita.php';

session_start();

if (isset($_SESSION['usuario']) && isset($_GET['id'])) {
  $usuario = unserialize($_SESSION['usuario']);
  $rp = new RepositorioCancion();
  $cancion = $rp->get_one($_GET['id']);
  if ($rp->delete($cancion)){
      $mensaje = "Cancion eliminada";
  } else {
      $mensaje = "Error al eliminar";
  }
  header("Location: home.php?$mensaje");

} else {
  header('Location: index.php');
}
?>