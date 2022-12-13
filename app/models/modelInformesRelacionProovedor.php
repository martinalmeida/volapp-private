<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class InformesRelacionProovedor
{
    // --Parametros Privados--
    private $conn;
    private $nombreModulo = "informes";
    private $tableAlquiler = "alquiler";
    private $tableFletes = "fletes";
    private $tableMovimientos = "movimientos";
    private $tableRutas = "rutas";
    private $tableRutContratos = "rutas_contratos";
    private $tableRegisAlquiler = "registros_alquiler";
    private $tableRegisFlete = "registros_fletes";
    private $tableRegisMovimientos = "registros_movimientos";
    private $tableMaquinarias = "maquinarias";
    private $tableContratos = "contratos";
    private $tableDedAlquiler = "deducibles_alquiler";
    private $tableDedFletes = "deducibles_fletes";
    private $tableDedMovimientos = "deducibles_movimientos";

    public $placa;
    public $contrato;
    public $fechaInicio;
    public $fechaFin;

    /* Propiedades de los objetos de Datatables para utilizar (Serverside) 
    Procesamiento del lado del servidor */
    public $row;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para permiso de lectura ⊡ --
    public function getReadPermisos(): void
    {
        $sesion = new Sesion($this->conn);
        $sesion->rol = $_SESSION['rol'];
        $sesion->tabla = $this->nombreModulo;

        $datos = $sesion->permisoModulo();

        if ($datos->r === 1) {
            echo json_encode(array('status' => NULL, 'data' => 1));
        } else {
            echo json_encode(array('status' => NULL, 'data' => 0));
        }
    }

    // -- ⊡ Funcion para traer boton de insertar ⊡ --
    public function getWritePermisos(): void
    {
        $sesion = new Sesion($this->conn);
        $sesion->rol = $_SESSION['rol'];
        $sesion->tabla = $this->nombreModulo;

        $datos = $sesion->permisoModulo();
        $html = "";

        if ($datos->w === 1) {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Informe de Relación para Proovedor</h1>';
            $html .= '<button type="button" class="btn btn-primary active m-1" onClick="history.go(-1); return false;"><i class="fal fa-arrow-left"></i> Regresar</button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Informe de Relación para Proovedor</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo </h3>';
            $html .= '<button type="button" class="btn btn-primary active m-1" onClick="history.go(-1); return false;"><i class="fal fa-arrow-left"></i> Regresar</button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function tableRelacionAlquiler(): void
    {
        $sqlRelacion = "";
        $this->placa != NULL ? $sqlRelacion .= " AND ra.idMaquinaria = $this->placa " : $sqlRelacion .= "";
        $this->contrato != NULL ? $sqlRelacion .= " AND c.id = $this->contrato " : $sqlRelacion .= "";
        $this->fechaInicio != NULL ? $sqlRelacion .= " AND STR_TO_DATE(ra.fechaInicio, '%m/%d/%Y') >= STR_TO_DATE('$this->fechaInicio', '%m/%d/%Y') " : $sqlRelacion .= "";
        $this->fechaFin != NULL ? $sqlRelacion .= " AND STR_TO_DATE(ra.fechaFin, '%m/%d/%Y') <= STR_TO_DATE('$this->fechaFin', '%m/%d/%Y') " : $sqlRelacion .= "";

        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT
                                      ra.id,
                                      m.placa,
                                      ra.fechaInicio,
                                      ra.fechaFin,
                                      c.titulo,
                                      ra.horometroInicial,
                                      ra.horometroFin,
                                      (ra.horometroFin - ra.horometroInicial)totalHoras,
                                      a.standby,
                                      a.horaTarifa,
                                      ((ra.horometroFin - ra.horometroInicial) * a.horaTarifa)subTotal,
                                      da.admon,
                                      da.retefuente,
                                      da.reteica,
                                      da.anticipo,
                                      da.otros,
                                      (((ra.horometroFin - ra.horometroInicial) * (a.horaTarifa)) - (IFNULL(da.admon,0) + IFNULL(da.retefuente,0) + IFNULL(da.reteica,0) + IFNULL(da.anticipo,0) + IFNULL(da.otros,0)))total,
                                      da.observacion  
                                      FROM $this->tableRegisAlquiler ra 
                                      JOIN $this->tableMaquinarias m ON ra.idMaquinaria = m.id
                                      JOIN $this->tableAlquiler a ON ra.idAlquiler = a.id 
                                      JOIN $this->tableContratos c ON a.idContrato = c.id 
                                      LEFT JOIN $this->tableDedAlquiler da ON da.idRegistro = ra.id 
                                      WHERE ra.status = 1 AND a.status = 1 $sqlRelacion GROUP BY ra.id ORDER BY m.placa DESC ");
        $stmt->execute();
        $empRecords = $stmt->fetchAll();
        $data = array();
        foreach ($empRecords as $row) {

            $data[] = array(
                "id" => $row['id'],
                "placa" => $row['placa'],
                "fechaInicio" => $row['fechaInicio'],
                "fechaFin" => $row['fechaFin'],
                "titulo" => $row['titulo'],
                "horometroInicial" => $row['horometroInicial'],
                "horometroFin" => $row['horometroFin'],
                "totalHoras" => $row['totalHoras'],
                "standby" => $row['standby'],
                "horaTarifa" => $row['horaTarifa'],
                "subTotal" => $row['subTotal'],
                "admon" => $row['admon'],
                "retefuente" => $row['retefuente'],
                "reteica" => $row['reteica'],
                "anticipo" => $row['anticipo'],
                "otros" => $row['otros'],
                "total" => $row['total'],
                "observacion" => $row['observacion']
            );
        }
        // --Response--
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function tableRelacionFlete(): void
    {
        $sqlRelacion = "";
        $this->placa != NULL ? $sqlRelacion .= " AND rf.idMaquinaria = $this->placa " : $sqlRelacion .= "";
        $this->contrato != NULL ? $sqlRelacion .= " AND c.id = $this->contrato " : $sqlRelacion .= "";
        $this->fechaInicio != NULL ? $sqlRelacion .= " AND STR_TO_DATE(rf.fechaInicio, '%m/%d/%Y') >= STR_TO_DATE('$this->fechaInicio', '%m/%d/%Y') " : $sqlRelacion .= "";
        $this->fechaFin != NULL ? $sqlRelacion .= " AND STR_TO_DATE(rf.fechaFin, '%m/%d/%Y') <= STR_TO_DATE('$this->fechaFin', '%m/%d/%Y') " : $sqlRelacion .= "";

        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT
                                      rf.id,
                                      rf.codFicha,
                                      m.placa,
                                      rf.fechaInicio,
                                      rf.fechaFin,
                                      c.titulo,
                                      concat(r.origen, ' - ', r.destino)ruta,
                                      f.flete,
                                      df.admon,
                                      df.retefuente,
                                      df.reteica,
                                      df.anticipo,
                                      df.otros,
                                      ((f.flete) - (IFNULL(df.admon,0) + IFNULL(df.retefuente,0) + IFNULL(df.reteica,0) + IFNULL(df.anticipo,0) + IFNULL(df.otros,0)))total,
                                      df.observacion 
                                      FROM $this->tableRegisFlete rf
                                      JOIN $this->tableMaquinarias m ON rf.idMaquinaria = m.id 
                                      JOIN $this->tableFletes f ON rf.idFlete = f.id 
                                      JOIN $this->tableRutas r ON f.idRuta = r.id 
                                      JOIN $this->tableRutContratos rc ON r.id = rc.idRuta 
                                      JOIN $this->tableContratos c ON rc.idContrato = c.id 
                                      LEFT JOIN $this->tableDedFletes df ON df.idRegistro = rf.id 
                                      WHERE rf.status = 1 AND f.status = 1 AND rc.status = 1 $sqlRelacion GROUP BY rf.id ORDER BY m.placa DESC ");
        $stmt->execute();
        $empRecords = $stmt->fetchAll();
        $data = array();
        foreach ($empRecords as $row) {

            $data[] = array(
                "id" => $row['id'],
                "codFicha" => $row['codFicha'],
                "placa" => $row['placa'],
                "fechaInicio" => $row['fechaInicio'],
                "fechaFin" => $row['fechaFin'],
                "titulo" => $row['titulo'],
                "ruta" => $row['ruta'],
                "flete" => $row['flete'],
                "admon" => $row['admon'],
                "retefuente" => $row['retefuente'],
                "reteica" => $row['reteica'],
                "anticipo" => $row['anticipo'],
                "otros" => $row['otros'],
                "total" => $row['total'],
                "observacion" => $row['observacion']
            );
        }
        // --Response--
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function tableRelacionMovimiento(): void
    {
        $sqlRelacion = "";
        $this->placa != NULL ? $sqlRelacion .= " AND rm.idMaquinaria = $this->placa " : $sqlRelacion .= "";
        $this->contrato != NULL ? $sqlRelacion .= " AND c.id = $this->contrato " : $sqlRelacion .= "";
        $this->fechaInicio != NULL ? $sqlRelacion .= " AND STR_TO_DATE(rm.fechaInicio, '%m/%d/%Y') >= STR_TO_DATE('$this->fechaInicio', '%m/%d/%Y') " : $sqlRelacion .= "";
        $this->fechaFin != NULL ? $sqlRelacion .= " AND STR_TO_DATE(rm.fechaFin, '%m/%d/%Y') <= STR_TO_DATE('$this->fechaFin', '%m/%d/%Y') " : $sqlRelacion .= "";

        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT
                                      rm.id,
                                      rm.codFicha,
                                      m.placa,
                                      rm.fechaInicio,
                                      rm.fechaFin,
                                      c.titulo,
                                      concat(r.origen, ' - ', r.destino)ruta,
                                      mo.kilometraje,
                                      mo.tarifa,
                                      rm.mts3,
                                      rm.peaje,
                                      rm.movimientos,
                                      dm.admon,
                                      dm.retefuente,
                                      dm.reteica,
                                      dm.anticipo,
                                      dm.otros,
                                      (((mo.kilometraje * mo.tarifa * rm.mts3) + rm.peaje ) - (IFNULL(dm.admon,0) + IFNULL(dm.retefuente,0) + IFNULL(dm.reteica,0) + IFNULL(dm.anticipo,0) + IFNULL(dm.otros,0)))total,
                                      dm.observacion 
                                      FROM $this->tableRegisMovimientos rm 
                                      JOIN $this->tableMaquinarias m ON rm.idMaquinaria = m.id 
                                      JOIN $this->tableMovimientos mo ON mo.idMaquinaria = m.id 
                                      JOIN $this->tableRutas r ON mo.idRuta = r.id 
                                      JOIN $this->tableRutContratos rc ON rc.idRuta = r.id 
                                      JOIN $this->tableContratos c ON rc.idContrato = c.id 
                                      LEFT JOIN $this->tableDedMovimientos dm ON dm.idRegistro = rm.id 
                                      WHERE rm.status = 1 AND mo.status = 1 AND rc.status = 1 $sqlRelacion GROUP BY rm.id ORDER BY m.placa DESC ");
        $stmt->execute();
        $empRecords = $stmt->fetchAll();
        $data = array();
        foreach ($empRecords as $row) {

            $data[] = array(
                "id" => $row['id'],
                "codFicha" => $row['codFicha'],
                "placa" => $row['placa'],
                "fechaInicio" => $row['fechaInicio'],
                "fechaFin" => $row['fechaFin'],
                "titulo" => $row['titulo'],
                "ruta" => $row['ruta'],
                "kilometraje" => $row['kilometraje'],
                "tarifa" => $row['tarifa'],
                "mts3" => $row['mts3'],
                "peaje" => $row['peaje'],
                "movimientos" => $row['movimientos'],
                "admon" => $row['admon'],
                "retefuente" => $row['retefuente'],
                "reteica" => $row['reteica'],
                "anticipo" => $row['anticipo'],
                "otros" => $row['otros'],
                "total" => $row['total'],
                "observacion" => $row['observacion']
            );
        }
        // --Response--
        $response = array(
            "aaData" => $data
        );
        echo json_encode($response);
    }
}
