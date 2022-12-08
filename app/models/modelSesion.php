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
    private $tableUsuarios = "usuarios";

    // --Parametros Publicos--
    public $idUser;
    public $rol;
    public $tabla;

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
                  JOIN $this->tablePermisos p ON p.moduloid = m.id 
                  JOIN $this->tableRol r ON r.id = p.rolid
                  JOIN $this->tableUsuarios u ON u.rolid = r.id 
                  WHERE ISNULL(m.menu_id) 
                  AND m.id NOT IN (SELECT m2.menu_id FROM $this->tablePermisos p2 JOIN $this->tableName m2 ON m2.id = p2.moduloid WHERE p2.r = 0 AND p2.rolid=? GROUP BY m2.menu_id HAVING COUNT(*)>=1)
                  AND m.status = 1 
                  AND p.r = 1
                  AND u.id=?
                  ORDER BY m.titulo ASC; ";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Traer el id del usuario ↓↓ --
        $this->rol = SesionTools::getParametro('rol');
        $this->idUser = SesionTools::getParametro('id');

        // -- ↓↓ Almacenamos los valores ↓↓ --
        $stmt->bindParam(1, $this->rol);
        $stmt->bindParam(2, $this->idUser);

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
                  JOIN $this->tablePermisos p ON p.moduloid = m.id 
                  JOIN $this->tableRol r ON r.id = p.rolid
                  JOIN $this->tableUsuarios u ON u.rolid = r.id 
                  WHERE m.menu_id = ?
                  AND m.status = 1 
                  AND p.r = 1
                  AND u.id=?
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
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            print_r($stmt->errorInfo());
        }
    }

    // -- ⊡ Funcion para traer datos de la empresa segun nit ⊡ --
    public function permisoModulo()
    {
        // --Preparamos la consulta--
        $query = "SELECT m.page, p.r, p.w, p.u, p.d FROM $this->tablePermisos p JOIN $this->tableName m on p.moduloid = m.id WHERE p.rolid=? AND m.page=? ;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->rol);
        $stmt->bindParam(2, $this->tabla);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                // --Retornamos las respuestas--
                return $stmt->fetch(PDO::FETCH_OBJ);
            }
        } else {
            // --Falla en la ejecución de la consulta--
            return NULL;
        }
    }
}
