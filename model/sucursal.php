<?php

/**
 *
 */
class Sucursal extends Slimapp
{

  private $sucursal_id = null;
  private $datos       = array();

  /**
   * GETTERS
   */
  public function getSucursalId()
  {
    return $this->sucursal_id;
  }

  /**
   * SETTERS
   */
  public function setSucursalId($sucursal_id)
  {
    $this->sucursal_id = $sucursal_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE SUCURSALES
   * @return array
   */
  public function getListadoS()
  {
    $this->conexion();
    $query = "SELECT * FROM sucursal";
    return $this->fetchAll($query);
  }

  /**
   * OBTIENE UNA SUCURSAL EN ESPECÍFICO
   * @return array
   */
  public function getSucursal()
  {
    $this->conexion();

    $query    = "SELECT * FROM sucursal WHERE sucursal_id=" . $this->sucursal_id;
    $sucursal = $this->fetchAll($query);

    if (!isset($sucursal[0])) {
      return array('notice' => array('text' => "No existe el sucursal especificado"));
    }

    return $sucursal;
  }

}
