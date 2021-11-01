<?php
require_once 'Usuario.php';
require_once 'RepositorioUsuario.php';
require_once 'CancionFavorita.php';
require_once 'RepositorioCancion.php';

class ControladorSesion
{
    protected $usuario = null;

    public function login($nombre_usuario, $clave)
    {
        $repo = new RepositorioUsuario();
        $usuario = $repo->login($nombre_usuario, $clave);
        if ($usuario === false) {
            return [false, "Error de credenciales"];
        } else {
            session_start();
            $_SESSION['usuario'] = serialize($usuario);
            return [true, "Usuario autenticado correctamente"];
        }
    }

    public function create($nombre_usuario, $nombre, $apellido, $clave)
    {
        $repo = new RepositorioUsuario();
        $usuario = new Usuario($nombre_usuario, $nombre, $apellido);
        $id = $repo->save($usuario, $clave);
        if ($id === false) {
            return [ false, "Error al crear el usuario"];
        }
        else {
            $usuario->setId($id);
            session_start();
            $_SESSION['usuario'] = serialize($usuario);
            return [ true, "Usuario creado correctamente" ];
        }
    }
    public function añadirCancion($userID, $nombreCancion, $genero, $artista)
    {
        $repo = new RepositorioCancion();
        $cancion = new CancionFavorita($userID, $nombreCancion, $genero, $artista);
        $id = $repo->save($cancion);
        if ($id === false) {
            return [ false, "Error en la creacion"];
        }
        else {
            $cancion->setId($id);
            return [ true, $cancion->getNombreCancion()  . " se añadio correctamente." ];
        }
    }
}