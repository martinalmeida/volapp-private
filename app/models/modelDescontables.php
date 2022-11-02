<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Descontable
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "rutas";

    // --Parametros Publicos--
    public $id;
    public $nombre;
    public $descripcion;
    public $status;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }



    // -- ⊡ Funcion para crear un material ⊡ --
    public function createRuta(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET nombre=?, descripcion=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->descripcion);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer datos del rol ⊡ --
    public function dataRuta(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, nombre, descripcion FROM $this->tableName WHERE id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                // --Cosulta a Objetos--
                $data = $stmt->fetch(PDO::FETCH_OBJ);

                $datos = array(
                    'id' => $data->id,
                    'nombre' => $data->nombre,
                    'descripcion' => $data->descripcion,
                );
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $datos));
            } else {
                // --Usuario no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para actualizar empresa ⊡ --
    public function updateRuta(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET nombre=?, descripcion=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->descripcion);
        $stmt->bindParam(3, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
