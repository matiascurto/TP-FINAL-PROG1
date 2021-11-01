<?php
require_once 'clases/Usuario.php';

class CancionFavorita
{
    public $id;
    public $userID;
    public $nombreCancion;
    public $genero;
    public $artista;

    public function __construct($userID, $nombreCancion, $genero, $artista, $id = null)
    {
        $this->id = $id;
        $this->nombreCancion = $nombreCancion;
        $this->genero = $genero;
        $this->artista = $artista;
        $this->userID = $userID;
    }

    public function getId() {

        return $this->id;
    }

    public function setId($id) {

        $this->id = $id;

    }

    public function getUser() {

        return $this->userID;
    
    }

    public function getNombreCancion() {
        
        return $this->nombreCancion;
    
    }
    
    public function getGenero() {
        
        return $this->genero;
    
    }

    public function getArtista() {
        
        return $this->artista;
    
    }

    public function editar($cancion){

        $this->nombreCancion = $cancion;

        return true;
    }

}