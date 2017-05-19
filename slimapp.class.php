<?php

include 'config/config.php';

/**
 *
 */
class SlimApp
{

  /****************************************************************************
  CLASS VARIABLES
   ****************************************************************************/
  public $cliente = null;
  public $conn    = null;
  public $tabla   = null;

  /****************************************************************************
  DATABASE CONNECTION  METHODS
   ****************************************************************************/
  public function conexion()
  {
    $this->conn = new PDO(
      DB_ENGINE . ':host=' . DB_IP . ';dbname=' . DB_NAME,
      DB_USER,
      DB_PASS
    );
  }

  /**
   * Método para asignar la tabla
   * @param [type] $tabla [description]
   */
  public function setTabla($tabla)
  {
    $this->tabla = $tabla;
  }

  /**
   * METHOD TO GET THE NAME OF THE TABLE
   * @return [type] [description]
   */
  public function getTabla()
  {
    return $this->tabla;
  }

  /**
   * regresa los campos separados por comas y por :=
   * @param  array  $datos      CONTAINS THE COLUMNS OF GET OR POST
   * @return [type]        [description]
   */
  public function getNombresColumnas($datos)
  {
    return array_keys($datos);
  }

  /**
   * RETURNS THE COLUMNS INGRESED SEPARATED WITH COMMAS OR ,=:
   * @param  array    $datos  CONTAINS THE COLUMNS OF THE TABLE
   * @param  String   $accion INDICATES THE DML OPERATION: INSERT OR UPDATE
   * @return [type]         [description]
   */
  public function getColumnas($datos, $accion = null)
  {
    $nombresColumnas = $this->getNombresColumnas($datos);
    $columnas        = "";
    for ($i = 0; $i < sizeof($nombresColumnas); $i++) {
      $columnas .= $nombresColumnas[$i];

      if ($accion == 'update') //si es por update se separa por =:
      {
        $columnas .= '=:' . $nombresColumnas[$i];
      }

      if ($i != sizeof($nombresColumnas) - 1) {
        $columnas .= ',';
      }
      //separa por comas
    }
    return $columnas;
  }

  /**
   * METHOD TO GET AN ASSOCIATIVE ARRAY WITH THE INFORMATION OF A QUERY
   * @param  String $query QUERY SQL
   * @return [type]        [description]
   */
  public function fetchAll($query)
  {
    $statement = $this->conn->Prepare($query);
    $statement->Execute();
    $datos = $statement->FetchAll(PDO::FETCH_ASSOC);
    return $datos;
  }

  /**
   * GENERIC METHOD TO INSERT ANY TABLE
   * @param  array  $datos      CONTAINS THE COLUMNS OF GET OR POST
   * @return [type]        [description]
   */
  public function insert($datos)
  {
    $nombresColumnas = $this->getNombresColumnas($datos);
    $columnas[0]     = $this->getColumnas($datos, 'insert');
    $columnas[1]     = ":" . str_replace(',', ',:', $columnas[0]);

    $sql = "insert into " . $this->getTabla() . " (" . $columnas[0] . ") values(" . $columnas[1] . ")";

    $stmt = $this->conn->prepare($sql);
    // $cadena = "";
    for ($i = 0; $i < sizeof($nombresColumnas); $i++) {
      $stmt->bindParam(':' . $nombresColumnas[$i], $datos[$nombresColumnas[$i]]);
      // $cadena .= ':' . $nombresColumnas[$i]." ". $datos[$nombresColumnas[$i]]." ";
    }
    $stmt->execute();
    // return $sql." ".$cadena;
  }

  /**
   * GENERIC METHOD TO UPDATE ANY TABLE
   * @param  array  $datos      CONTAINS THE COLUMNS OF GET OR POST
   * @param  String $id         INDICATES PRIMARY KEY
   * @param  array  $condition  ELEMENTS OF WHERE CONDITION
   * @return [type]            [description]
   */
  public function update($datos, $condition = null)
  {
    $nombresColumnas = $this->getNombresColumnas($datos);
    $columnas        = $this->getColumnas($datos, 'update');

    $where = "";
    if (!empty($condition)) {
      $where                = " where ";
      $nombresColumnasWhere = array_keys($condition);
      for ($i = 0; $i < sizeof($nombresColumnasWhere); $i++) {
        $where .= $nombresColumnasWhere[$i];
        $where .= '=:' . $nombresColumnasWhere[$i];
        if ($i != sizeof($nombresColumnasWhere) - 1) {
          $where .= ' and ';
        }

      }
    }

    $sql = "update " . $this->getTabla() . " set " . $columnas . $where;

    // echo $sql . "<br>";

    $stmt = $this->conn->prepare($sql);
    for ($i = 0; $i < sizeof($nombresColumnas); $i++) {
      $stmt->bindParam(':' . $nombresColumnas[$i], $datos[$nombresColumnas[$i]]);

      // echo $nombresColumnas[$i] . " " . $datos[$nombresColumnas[$i]] . "<br>";
    }

    $stmt->execute();
  }

  /**
   * GENERIC METHOD TO DELETE ANY TABLE
   * @param  array  $datos      CONTAINS THE COLUMNS OF GET OR POST
   * @param  String $id         INDICATES PRIMARY KEY
   * @param  array  $condition  ELEMENTS OF WHERE CONDITION
   * @return [type]            [description]
   */
  public function delete($condition = null)
  {
    $nombresColumnas = $this->getNombresColumnas($condition);
    // $columnas        = $this->getColumnas($datos, 'update');

    $where = "";
    if (!empty($condition)) {
      $where                = " where ";
      $nombresColumnasWhere = array_keys($condition);
      for ($i = 0; $i < sizeof($nombresColumnasWhere); $i++) {
        $where .= $nombresColumnasWhere[$i];
        $where .= '=:' . $nombresColumnasWhere[$i];
        if ($i != sizeof($nombresColumnasWhere) - 1) {
          $where .= ' and ';
        }

      }
    }

    $sql  = "DELETE FROM " . $this->getTabla() . $where;
    $stmt = $this->conn->prepare($sql);
    for ($i = 0; $i < sizeof($nombresColumnas); $i++) {
      $stmt->bindParam(':' . $nombresColumnas[$i], $condition[$nombresColumnas[$i]]);
    }
    $stmt->execute();
  }

  /**
   * FACILITA EL MANEJO DE FALLAS
   * @param  array
   */
  public function debug($elements)
  {
    echo "<pre>";
    print_r($elements);
  }

}

// include 'model/empleado.php';
// include 'model/local.php';
// include 'model/proveedor.php';
include 'model/compra.php';
include 'model/asientos_reservados.php';
include 'model/sala_asientos.php';
include 'model/funcion.php';
include 'model/pelicula.php';
include 'model/sala.php';
include 'model/sucursal.php';
include 'model/bitacora.php';

$web = new SlimApp;
$web->conexion();
