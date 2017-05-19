<?php

/**
 *
 */
class Sala extends Slimapp
{

  private $sala_id = null;
  private $datos   = array();

  /**
   * GETTERS
   */
  public function getSalaId()
  {
    return $this->sala_id;
  }

  /**
   * SETTERS
   */
  public function setSalaId($sala_id)
  {
    $this->sala_id = $sala_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE SALAS
   * @return array
   */
  public function getListadoS()
  {
    $this->conexion();
    $query = "SELECT * FROM sala";
    $salas = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($salas); $i++) {
      $sucursal = new Sucursal;
      $sucursal->setSucursalId($salas[$i]['sucursal_id']);
      $salas[$i]['sucursal'] = $sucursal->getSucursal();
    }

    return $salas;
  }

  /**
   * OBTIENE UNA SALA EN ESPECÍFICO
   * @return array
   */
  public function getSala()
  {
    $this->conexion();

    $query = "SELECT * FROM sala WHERE sala_id=" . $this->sala_id;
    $sala  = $this->fetchAll($query);

    if (!isset($sala[0])) {
      return array('notice' => array('text' => "No existe el sala especificado"));
    }

    $sucursal = new Sucursal;
    $sucursal->setSucursalId($sala[0]['sucursal_id']);
    $sala[0]['sucursal'] = $sucursal->getSucursal();

    return $sala;
  }

}
