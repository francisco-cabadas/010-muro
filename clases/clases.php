<?php

abstract class Dato{

}

trait Identificable
{
    protected $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
class Usuario  {
    use Identificable;

    private  $identificador;
    private  $nombre;
    private  $apellidos;
    private  $correo;
    private  $contraseña;


    public function __construct($id, $identificador, $nombre, $apellidos, $correo, $contraseña)
    {
        $this->id=$id;
        $this->identificador = $identificador;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->contraseña = $contraseña;
    }


    public function getIdentificador()
    {
        return $this->identificador;
    }


    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;
    }


    public function getNombre()
    {
        return $this->nombre;
    }


    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }


    public function getApellidos()
    {
        return $this->apellidos;
    }


    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }


    public function getCorreo()
    {
        return $this->correo;
    }


    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }


    public function getContraseña()
    {
        return $this->contraseña;
    }


    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;
    }


}
class Mensaje{

    private $fecha;
    private $texto;
    private $identificador;

    public function __construct($fecha, $texto, $identificador)
    {
        $this->fecha = $fecha;
        $this->texto = $texto;
        $this->identificador = $identificador;
    }

    public function getFecha()
    {
        return $this->fecha;
    }


    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getTexto()
    {
        return $this->texto;
    }


    public function setTexto($texto)
    {
        $this->texto = $texto;
    }


    public function getIdentificador()
    {
        return $this->identificador;
    }


    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;
    }
    

}
?>