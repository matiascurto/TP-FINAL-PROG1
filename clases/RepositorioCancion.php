<?php
require_once '.env.php';
require_once 'clases/CancionFavorita.php';
require_once 'clases/Usuario.php';

class RepositorioCancion {

    private static $conexion = null;

    public function __construct()
    {
        if (is_null(self::$conexion)) {
            $credenciales = credenciales();
            self::$conexion = new mysqli(   $credenciales['servidor'],
                                            $credenciales['usuario'],
                                            $credenciales['clave'],
                                            $credenciales['base_de_datos']);
            if(self::$conexion->connect_error) {
                $error = 'Error de conexión: '.self::$conexion->connect_error;
                self::$conexion = null;
                die($error);
            }
            self::$conexion->set_charset('utf8'); 
        }
    }


    public function save(CancionFavorita $u)
    {
        $q = "INSERT INTO cancionesfavoritas (id_usuario, nombre_cancion, genero, artista)";
        $q.= "VALUES (?, ?, ?, ?)";
        $query = self::$conexion->prepare($q);

        $query->bind_param("ssss", $u->getUser(), $u->getNombreCancion(), $u->getGenero(), $u->getArtista());
        echo $clave;

        if ( $query->execute() ) {
            return self::$conexion->insert_id;
        }
        else {
            return false;
        }


    }
    public function get_all(Usuario $usuario)
    {
        $idUsuario = $usuario->getId();
        $q = "SELECT id, nombre_cancion, genero, artista FROM cancionesfavoritas WHERE id_usuario = ?";
        try {
            $query = self::$conexion->prepare($q);
            $query->bind_param("i", $idUsuario);
            $query->bind_result($id, $nombreCancion, $genero, $artista);

            if ($query->execute()) {
                $listaCanciones = array();
                while ($query->fetch()) {
                    $listaCanciones[] = new CancionFavorita($usuario, $nombreCancion, $genero, $artista, $id);
                }
                return $listaCanciones;
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    } 
    public function get_one($id)
    {
        $q = "SELECT nombre_cancion, id_usuario, genero, artista FROM cancionesfavoritas WHERE id = ?";
        try {
            $query = self::$conexion->prepare($q);
            $query->bind_param("i", $id);
            $query->bind_result($nombreCancion, $idUsuario, $genero, $artista);

            if ($query->execute()) {
                if ($query->fetch()) {
                    $ru = new RepositorioUsuario();
                    $usuario = $ru->get_one($idUsuario);
                    return new CancionFavorita($usuario, $nombreCancion, $genero, $artista, $id);
                }
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    } 
    public function delete(CancionFavorita $cancion)
    {
        $n = $cancion->getId();
        $q = "DELETE FROM cancionesfavoritas WHERE id = ?";
        $query = self::$conexion->prepare($q);
        $query->bind_param("i", $n);
        return ($query->execute());
    }

    public function actualizarDatos(CancionFavorita $cancion)
    {
        $i = $cancion->getId();
        $n = $cancion->getNombreCancion();
        $g = $cancion->getGenero();
        $a = $cancion->getArtista();

        $q = "UPDATE cancionesfavoritas SET nombre_cancion  = ?, genero = ?, artista  = ? WHERE id = ?";

        $query = self::$conexion->prepare($q);
        $query->bind_param("sssi", $n, $g,$a, $i );

        return $query->execute();
    }
}