<?php

declare(strict_types=1);

include_once(LIBRARIES . 'sesion.php');

class Sesion
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "modulo";
    private $tablePermisos = "permisos";
    private $tableRol = "rol";
    private $tablePersona = "persona";

    // --Parametros Publicos--
    public $idUser;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para traer el menu del usuario ⊡ --
    public function getMenuDinamico(): void
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "SELECT m.id, m.titulo, m.descripcion, m.icono 
                  FROM $this->tableName m 
                  JOIN $this->tablePermisos pe ON pe.moduloid = m.id 
                  JOIN $this->tableRol r ON r.id = pe.rolid
                  JOIN $this->tablePersona p ON p.rolid = r.id 
                  WHERE ISNULL(m.menu_id) 
                  AND m.status = 1 
                  AND p.id=?
                  ORDER BY m.titulo ASC; ";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Traer el id del usuario ↓↓ --
        $this->idUser = SesionTools::getParametro('id');

        // -- ↓↓ Almacenamos los valores ↓↓ --
        $stmt->bindParam(1, $this->idUser);

        // -- ↓↓ Ejecutamos la consulta y validamos ejecucion ↓↓ --
        if ($stmt->execute()) {
            $html = "";
            // -- ↓↓ Comprobamos que venga algun dato ↓↓ --
            if ($stmt->rowCount() >= 1) {
                // -- ↓↓ Modulos encontrados ↓↓ --
                $data = $stmt->fetchAll();

                foreach ($data as $row) {
                    echo "<li><a href='#' title='" . $row['descripcion'] . "' data-filter-tags='" . $row['titulo'] . "'><i class='" . $row['icono'] . "'></i><span class='nav-link-text' data-i18n='nav.theme_settings'>" . $row['titulo'] . "</span></a><ul>";

                    $submodulos = self::getSubmodulo($row['id'], $this->idUser);
                    foreach ($submodulos as $rowsub) {
                        echo "<li><a href='../" . $rowsub['page'] . "/' title='" . $rowsub['descripcion'] . "' data-filter-tags='" . $rowsub['titulo'] . "'><span class='nav-link-text' data-i18n='nav.theme_settings_how_it_works'>" . $rowsub['titulo'] . "</span></a></li>";
                    }

                    echo '</ul></li>';
                }
            } else {
                // -- ↓↓ Modulos no encontrados ↓↓ --
                echo json_encode(array('status' => '6', 'data' => NULL));
                exit;
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            print_r($stmt->errorInfo());
        }
    }

    // -- ⊡ Funcion para traer los submodulos ⊡ --
    private function getSubmodulo($idModulo, $idUser)
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "SELECT m.id, m.page, m.titulo, m.descripcion 
                  FROM $this->tableName m 
                  JOIN $this->tablePermisos pe ON pe.moduloid = m.id 
                  JOIN $this->tableRol r ON r.id = pe.rolid
                  JOIN $this->tablePersona p ON p.rolid = r.id 
                  WHERE m.menu_id = ?
                  AND m.status = 1 
                  AND p.id=?
                  ORDER BY m.titulo ASC; ";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Almacenamos los valores ↓↓ --
        $stmt->bindParam(1, $idModulo);
        $stmt->bindParam(2, $idUser);

        // -- ↓↓ Ejecutamos la consulta y validamos ejecucion ↓↓ --
        if ($stmt->execute()) {

            // -- ↓↓ Comprobamos que venga algun dato ↓↓ --
            if ($stmt->rowCount() >= 1) {
                // -- ↓↓ Submodulos encontrados ↓↓ --
                $data = $stmt->fetchAll();
                return $data;
            } else {
                // -- ↓↓ Submodulos no encontrados ↓↓ --
                echo json_encode(array('status' => '6', 'data' => NULL));
                exit;
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            print_r($stmt->errorInfo());
        }
    }
}
