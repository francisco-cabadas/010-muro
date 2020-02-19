<?php

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
class Usuario
{
    use Identificable;

    private $identificador;
    private $contrasenna;
    private $codigoCookie;
    private $tipoUsuario;
    private $nombre;
    private $apellidos;


    public function __construct($id,$identificador, $contrasenna, $codigoCookie, $tipoUsuario, $nombre, $apellidos)
    {
        $this->id=$id;
        $this->identificador = $identificador;
        $this->contrasenna = $contrasenna;
        $this->codigoCookie = $codigoCookie;
        $this->tipoUsuario = $tipoUsuario;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
    }


    public function getIdentificador()
    {
        return $this->identificador;
    }



    public function setIdentificador($identificador): void
    {
        $this->identificador = $identificador;
    }


    public function getContrasenna()
    {
        return $this->contrasenna;
    }


    public function setContraseña($contrasenna): void
    {
        $this->contrasenna = $contrasenna;
    }


    public function getCodigoCookie()
    {
        return $this->codigoCookie;
    }


    public function setCodigoCookie($codigoCookie): void
    {
        $this->codigoCookie = $codigoCookie;
    }


    public function getTipoUsuario()
    {
        return $this->tipoUsuario;
    }


    public function setTipoUsuario($tipoUsuario): void
    {
        $this->tipoUsuario = $tipoUsuario;
    }


    public function getNombre()
    {
        return $this->nombre;
    }


    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }


    public function getApellidos()
    {
        return $this->apellidos;
    }


    public function setApellidos($apellidos): void
    {
        $this->apellidos = $apellidos;
    }




}
class Mensaje{

    private $identificador;
    private $mensaje;
    private $fecha;
    use Identificable;



    public function __construct($identificador, $mensaje, $fecha, $id)
    {

        $this->identificador = $identificador;
        $this->mensaje = $mensaje;
        $this->fecha = $fecha;
        $this->id=$id;

    }

    public function getFecha(): string
    {
        return $this->fecha;
    }


    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }


    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
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