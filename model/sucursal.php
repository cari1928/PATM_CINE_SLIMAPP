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
   * LISTADO DE SUCURSALES, CON LÍMITE DE TIEMPO
   * @return array
   */
  public function getListApp()
  {
    $this->conexion();
    $query = "SELECT DISTINCT sucursal.sucursal_id, pais, ciudad, direccion, latitud, longitud
    FROM sucursal
    INNER JOIN sala ON sala.sucursal_id = sucursal.sucursal_id
    INNER JOIN funcion ON funcion.sala_id = sala.sala_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))
    ORDER BY sucursal.sucursal_id";

    return $this->fetchAll($query);
  }

  /**
   * LISTADO DE SUCURSALES, SIN LÍMITE DE TIEMPO
   * @return array
   */
  public function getListado()
  {
    $this->conexion();
    $query = "SELECT * FROM sucursal ORDER BY sucursal_id";
    return $this->fetchAll($query);
  }

  /**
   * OBTIENE UNA SUCURSAL EN ESPECÍFICO, CON LÍMITE DE TIEMPO
   * @return array
   */
  public function getSucursalApp()
  {
    $this->conexion();

    $query = "SELECT DISTINCT sucursal.sucursal_id, pais, ciudad, direccion, latitud, longitud
    FROM sucursal
    INNER JOIN sala ON sala.sucursal_id = sucursal.sucursal_id
    INNER JOIN funcion ON funcion.sala_id = sala.sala_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))
    AND sucursal_id=" . $this->sucursal_id;
    $sucursal = $this->fetchAll($query);

    if (!isset($sucursal[0])) {
      return array('notice' => array('text' => "No existe el sucursal especificado"));
    }

    return $sucursal;
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
