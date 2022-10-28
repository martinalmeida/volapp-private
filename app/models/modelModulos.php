<?php

declare(strict_types=1);

class Modulo
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "modulo";
    private $tablePermisos = "permisos";
    private $tableRol = "rol";

    // --Parametros Publicos--
    public $id;
    public $idRol;
    public $idModulo;


    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para traer datos de los modulos ⊡ --
    public function modulosPrincipales(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, icono, titulo FROM $this->tableName WHERE menu_id IS NULL AND page IS NULL AND status = 1 ;";
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
                        "icono" => $row["icono"],
                        "titulo" => $row["titulo"]
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

    // -- ⊡ Funcion para traer datos de los modulos ⊡ --
    public function dataModulo(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, menu_id, titulo, descripcion FROM $this->tableName WHERE menu_id IS NOT NULL AND page IS NOT NULL AND status = 1 ;";
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

    // -- ⊡ Funcion para traer modulos asiganados al rol⊡ --
    public function modulosAsiganados(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT m.id, m.titulo FROM $this->tableRol r JOIN $this->tablePermisos p ON p.rolid = r.id JOIN $this->tableName m ON p.moduloid = m.id 
                  WHERE m.menu_id IS NOT NULL AND m.page IS NOT NULL AND m.status = 1 AND p.rolid =? AND m.menu_id =? GROUP BY m.id ; ";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->idRol);
        $stmt->bindParam(2, $this->idModulo);

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
                        "titulo" => $row["titulo"],
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

    // -- ⊡ Funcion para traer modulos no asiganados al rol⊡ --
    public function modulosNoAsiganados(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT m.id, m.titulo FROM $this->tableRol r JOIN $this->tablePermisos p ON p.rolid = r.id JOIN $this->tableName m ON p.moduloid = m.id 
                  WHERE m.menu_id IS NOT NULL AND m.page IS NOT NULL AND m.status = 1 AND p.rolid =? AND m.menu_id =? GROUP BY m.id ; ";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->idRol);
        $stmt->bindParam(2, $this->idModulo);

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
                        "titulo" => $row["titulo"],
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
        $query = "SELECT m.id, p.r, p.w, p.u, p.d FROM $this->tableName m JOIN $this->tablePermisos p ON p.moduloid = m.id 
                  WHERE m.status = 1 AND p.rolid = ? AND p.moduloid = ? AND m.menu_id IS NOT NULL AND m.page IS NOT NULL ;";

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
}
