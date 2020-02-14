<?php
class DAO
{

    //---------------GENERICOS
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "muro"; // Schema
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
        $select->execute($parametros);
        return $select->fetchAll();
    }

    private static function ejecutarActualizacion($sql, $parametros): void
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $actualizacion->execute($parametros);
    }





    //----------------------- para mensajes

    //obtener mensajes de la bd(se utiliza en listado-muro para ver todos los mensajes que hay)
    public static function mensajeObtenerTodos(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta("SELECT * FROM publicacion", []);

        foreach ($rs as $fila) {
            $mensaje = new Mensaje($fila["fecha"], $fila["mensaje"], $fila["identificador"]);
            array_push($datos, $mensaje);
        }
        return $datos;
    }

    public static function agregarMensaje($fecha, $mensaje, $identificador)
    {
        self::ejecutarActualizacion("INSERT INTO publicacion (fecha, mensaje, identificador) VALUES (?, ?, ?);",
            [$fecha, $mensaje, $identificador]);
    }


//--------------------------------------para usuario

    private static function crearUsuarioDesdeRs(array $rs): Usuario
    {
        return new Usuario($rs[0]["id"], $rs[0]["identificador"], $rs[0]["Nombre"], $rs[0]["apellidos"], $rs[0]["correo"], $rs[0]["contrasenna"]);
    }


    //coge por parametro el identificador, y devuelve una clase Usuario con todos los datos, si queremos acceder a un atributo en concreto del Usuario, tendriamos que hacer algo así.
    // ($identificador=DAO::usuarioObtenerPorId("fran_95") -->aquí podemos pasarle la saesion o cookie de usuario;
    // $identificador->getNombre();)

    public static function usuarioObtenerPorId($identificador): Usuario
    {
        $rs = self::ejecutarConsulta("SELECT * FROM usuario WHERE identificador=?", [$identificador]);
        if ($rs) return self::crearUsuarioDesdeRs($rs);
        else return null;
    }
}
?>