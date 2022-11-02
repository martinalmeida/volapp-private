<?php

declare(strict_types=1);

class Modulo
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "modulo";
    private $tablePermisos = "permisos";

    // --Parametros Publicos--
    public $id;
    public $idRol;
    public $idModulo;
    public $read;
    public $write;
    public $update;
    public $delete;
    public $idPermiso;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para traer datos de los modulos ⊡ --
    public function dataModulo(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, menu_id, titulo, descripcion FROM $this->tableName WHERE menu_id IS NOT NULL AND page IS NOT NULL AND status = 1 ORDER BY titulo ASC ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $arrayModulos = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $arrayModulos[] = array(
                        "id" => $row["id"],
                        "idMenu" => $row["menu_id"],
                        "titulo" => $row["titulo"],
                        "descripcion" => $row["descripcion"],
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $arrayModulos));
            } else {
                // --Modulos no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer permisos del modulo ⊡ --
    public function dataPermissions(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT (p.id)idpermiso, m.id, p.r, p.w, p.u, p.d FROM $this->tableName m JOIN $this->tablePermisos p ON p.moduloid = m.id 
                  WHERE m.status = 1 AND p.rolid = ? AND p.moduloid = ? ;";

        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->idRol);
        $stmt->bindParam(2, $this->id);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $arrayPermisosModulo = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $arrayPermisosModulo[] = array(
                        "idPermiso" => $row["idpermiso"],
                        "idModulo" => $row["id"],
                        "r" => $row["r"],
                        "w" => $row["w"],
                        "u" => $row["u"],
                        "d" => $row["d"],
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $arrayPermisosModulo));
            } else {
                // --Modulos no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para cambiar el estado del permiso ⊡ --
    public function readPermisos(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tablePermisos SET r=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $permiso = $this->read == '1' ? '0' : '1';

        // --Almacenamos los valores--
        $stmt->bindParam(1, $permiso);
        $stmt->bindParam(2, $this->idPermiso);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para cambiar el estado del permiso ⊡ --
    public function writePermisos(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tablePermisos SET w=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $permiso = $this->write == '1' ? '0' : '1';

        // --Almacenamos los valores--
        $stmt->bindParam(1, $permiso);
        $stmt->bindParam(2, $this->idPermiso);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para cambiar el estado del permiso ⊡ --
    public function updatePermisos(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tablePermisos SET u=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $permiso = $this->update == '1' ? '0' : '1';

        // --Almacenamos los valores--
        $stmt->bindParam(1, $permiso);
        $stmt->bindParam(2, $this->idPermiso);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para cambiar el estado del permiso ⊡ --
    public function deletePermisos(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tablePermisos SET d=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $permiso = $this->delete == '1' ? '0' : '1';

        // --Almacenamos los valores--
        $stmt->bindParam(1, $permiso);
        $stmt->bindParam(2, $this->idPermiso);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
