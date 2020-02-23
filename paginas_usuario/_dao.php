<?php
class DAO
{

    //---------------GENERICOS
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";                        //copia pega
        $contrasenna = "";
        $bd = "minifb"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }


    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);                     //copia pega
        return $select->fetchAll();
    }

    private static function ejecutarActualizacion($sql, $parametros): void
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);                             //copia pega
        $actualizacion->execute($parametros);
    }


    public static function usuarioObtenerPorIdentificadorContaseña($identificador, $contrasenna): Usuario        //se utiliza para iniciar sesion contra la bdd
    {
        $rs = self::ejecutarConsulta("SELECT * FROM usuario WHERE identificador=? AND BINARY contrasenna=?",
            [$identificador, $contrasenna]);
        if ($rs) {
            return self::crearUsuarioDesdeRs($rs);
        } else {
            return null;
        }
    }

    public static function usuarioObtenerPorIdentificadorYCodigoCookie($identificador, $codigoCookie): Usuario
    {
        $rs = self::ejecutarConsulta("SELECT * FROM usuario WHERE identificador=? AND BINARY codigoCookie=?",
            [$identificador, $codigoCookie]);
        if ($rs) {
            return self::crearUsuarioDesdeRs($rs);
        } else {
            return null;
        }
    }


    public static function clienteGuardarCodigoCookie(string $identificador, string $codigoCookie = null)
    {
        if ($codigoCookie != null)
        {
            self::ejecutarActualizacion("UPDATE usuario SET codigoCookie=? WHERE identificador=?", [$codigoCookie, $identificador]);
        } else {
            self::ejecutarActualizacion("UPDATE usuario SET codigoCookie=NULL WHERE identificador=?", [$identificador]);
        }

    }




    //----------------------- para mensajes

    //obtener mensajes de la bd(se utiliza en listado-muro para ver todos los mensajes que hay)
    public static function mensajeObtenerTodos(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta("SELECT * FROM mensajes", []);

        foreach ($rs as $fila) {
            $mensaje = new Mensaje($fila["identificador"], $fila["mensaje"], $fila["fecha"], $fila["id"]);
            array_push($datos, $mensaje);
        }
        return $datos;
    }

    public static function agregarMensaje($identificador, $mensaje, $fecha)
    {
        $sql = "INSERT INTO mensajes (identificador, mensaje, fecha) VALUES (?, ?, ?);";
        self::ejecutarActualizacion($sql, [$identificador,$mensaje,$fecha]);
    }

    public static function borrarMensaje($id)
    {
        $sql = "DELETE from mensajes WHERE id=?;";
        self::ejecutarActualizacion($sql, [$id]);
    }




//--------------------------------------para usuario

    private static function crearUsuarioDesdeRs(array $rs): Usuario
    {
        return new Usuario($rs[0]["id"], $rs[0]["identificador"], $rs[0]["contrasenna"], $rs[0]["codigoCookie"], $rs[0]["tipoUsuario"], $rs[0]["nombre"], $rs[0]["apellidos"]);
    }


    //coge por parametro el identificador, y devuelve una clase Usuario con todos los datos, si queremos acceder a un atributo en concreto del Usuario, tendriamos que hacer algo así.
    // ($identificador=DAO::usuarioObtenerPorId("fran_95") -->aquí podemos pasarle la saesion o cookie de usuario;
    // $identificador->getNombre();)

    public static function usuarioObtenerPorIdentificador($identificador): Usuario
    {
        $rs = self::ejecutarConsulta("SELECT * FROM usuario WHERE identificador=?", [$identificador]);
        if ($rs) return self::crearUsuarioDesdeRs($rs);
        else return null;
    }
}


?>