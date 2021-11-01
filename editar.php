<?php
 require_once 'clases/Usuario.php';
 require_once 'clases/RepositorioCancion.php';
 require_once 'clases/RepositorioUsuario.php';
 require_once 'clases/CancionFavorita.php';

 session_start();

 if (isset($_SESSION['usuario']) && isset($_POST['cancion'])) {
     $usuario = unserialize($_SESSION['usuario']);
     $rp = new RepositorioCancion();
     $cancion = $rp->get_one($_POST['numeroCancion']);
     if ($cancion->getUser()->getId() != $usuario->getId()) {
         die("Error: La cancion no pertenece al usuario");
     }
     if ($_POST['editar'] == 'e') {
         $r = $cancion->editar($_POST['cancion']);
     }
     if ($r) {
         $rp->actualizarDatos($cancion);
         $respuesta['resultado'] = "OK";
     } else {
         $respuesta['resultado'] = "Error al realizar la operación";
     }

     $respuesta['id'] = $cancion->getId();
     $respuesta['cancion'] = $cancion->getNombreCancion();
     echo json_encode($respuesta);
 }
