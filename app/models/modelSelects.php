<?php

declare(strict_types=1);

class Select
{
    // --Parametros Privados--
    private $conn;
    private $tableSucursal = "sucursal";
    private $tableRol = "rol";
    private $tablePlaca = "vehiculos";
    private $tableRuta = "rutas";
    private $tableMaterial = "materiales";
    private $tableContrato = "contratos";


    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para traer html del select Sucursal ⊡ --
    public function selectSucursales(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableSucursal WHERE status = 1 ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">' . $row["descripcion"] . '</option>',
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $selctHtml));
            } else {
                // --Modulos no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer html del select Rol ⊡ --
    public function selectRol(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableRol WHERE status = 1 AND id != 1 ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">' . $row["nombrerol"] . '</option>',
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $selctHtml));
            } else {
                // --Modulos no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer html del select Placa ⊡ --
    public function selectPlaca(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tablePlaca WHERE status = 1 ORDER BY placa ASC ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">' . $row["placa"] . '</option>',
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $selctHtml));
            } else {
                // --Modulos no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer html del select Ruta ⊡ --
    public function selectRuta(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableRuta WHERE status = 1 ORDER BY nombre ASC ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">' . $row["nombre"] . '</option>',
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $selctHtml));
            } else {
                // --Modulos no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer html del select Material ⊡ --
    public function selectMaterial(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableMaterial WHERE status = 1 ORDER BY nombre ASC ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">' . $row["nombre"] . '</option>',
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $selctHtml));
            } else {
                // --Modulos no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    public function selectContrato(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableContrato WHERE status = 1 ORDER BY nombre ASC ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">' . $row["nombre"] . '</option>',
                    );
                }
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $selctHtml));
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
