<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Select
{
    // --Parametros Privados--
    private $conn;
    private $tableSucursal = "sucursal";
    private $tableRol = "rol";
    private $tableMaquinarias = "maquinarias";
    private $tableRuta = "rutas";
    private $tableMaterial = "materiales";
    private $tableContrato = "contratos";
    private $tableTipoMaquinaria = "tipo_maquinaria";
    private $tableAlquiler = "alquiler";
    private $tableFletes = "fletes";
    private $tableMovimientos = "movimientos";

    public $id;

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
    public function selectVehiculo(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableMaquinarias WHERE status = 1 AND nit =  " . $_SESSION['nit'] . "  ORDER BY placa ASC ;";
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
                        "html" => '<option value="' . $row["id"] . '">' . $row["nombre"] . '  (' . $row["origen"] . ' - ' . $row["destino"] . ' )</option>',
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
        $query = "SELECT * FROM $this->tableContrato WHERE status = 1 AND nit = " . $_SESSION['nit'] . " ORDER BY titulo ASC ;";
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
                        "html" => '<option value="' . $row["id"] . '">' . $row["titulo"] . '</option>',
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

    public function selectTipoMaquinaria(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableTipoMaquinaria ORDER BY tipo ASC ;";
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
                        "html" => '<option value="' . $row["id"] . '">' . $row["tipo"] . '</option>',
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

    public function selectAcuerdoAlquiler(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableAlquiler WHERE idMaquinaria = ? AND standby != 0 ;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '"> STANDBY: (' . $row["standby"] . ' hras) - TARIFA POR HORA: (' . $row["horaTarifa"] . ' *hra)</option>',
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

    public function selectAcuerdoFlete(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT f.id, r.origen, r.destino FROM $this->tableFletes f JOIN rutas r ON f.idRuta = r.id WHERE f.idMaquinaria = ? AND f.flete != 0 ;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">ORIGEN: ' . $row["origen"] . ' - DESTINO: ' . $row["destino"] . '</option>',
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

    public function selectAcuerdoMovimiento(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT m.id, r.origen, r.destino FROM $this->tableMovimientos m JOIN rutas r ON m.idRuta = r.id WHERE m.idMaquinaria = ? AND m.tarifa != 0 ;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // -- ↓↓ Preparamos arreglo de modulos ↓↓ --
        $selctHtml = array();

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $selctHtml[] = array(
                        "html" => '<option value="' . $row["id"] . '">ORIGEN: ' . $row["origen"] . ' - DESTINO: ' . $row["destino"] . '</option>',
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
