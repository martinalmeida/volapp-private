<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Registro
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "registros";
    private $tablePlaca = "vehiculos";
    private $tableRuta = "rutas";
    private $tableMaterial = "materiales";
    private $tableUser = "usuarios";
    private $fechaActual;
    private $nit;

    // --Parametros Publicos--
    public $id;
    public $placa;
    public $ruta;
    public $material;
    public $nota;
    public $status;

    /* Propiedades de los objetos de Datatables para utilizar (Serverside) 
    Procesamiento del lado del servidor */
    public $draw;
    public $row;
    public $rowperpage;
    public $columnIndex;
    public $columnName;
    public $columnSortOrder;
    public $searchValue;


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
        $sesion->tabla = $this->tableName;

        $datos = $sesion->permisoModulo();

        if ($datos->r === 1) {
            echo json_encode(array('status' => NULL, 'data' => 1));
        } else {
            echo json_encode(array('status' => NULL, 'data' => 0));
        }
    }
}
