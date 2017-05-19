<?php

/**
 *
 */
class SalaAsientos extends Slimapp
{

  private $sala_id    = null;
  private $asiento_id = null;
  private $datos      = array();

  /**
   * GETTERS
   */
  public function getSalaId()
  {
    return $this->sala_id;
  }

  public function getAsientoId()
  {
    return $this->asiento_id;
  }

  /**
   * SETTERS
   */
  public function setSalaId($sala_id)
  {
    $this->sala_id = $sala_id;
  }

  public function setAsientoId($asiento_id)
  {
    $this->asiento_id = $asiento_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE SALA-ASIENTOS DESOCUPADOS
   * @return array
   */
  public function getListadoSA()
  {
    $this->conexion();
    $query = "SELECT * FROM sala_asientos
    WHERE sala_id=" . $this->sala_id .
      " AND estado=0"; //se obtienen los asientos desocupados
    return $this->fetchAll($query);
  }

  /**
   * OBTIENE UN ASIENTO DE UNA SALA EN ESPECÍFICO
   * @return array
   */
  public function getSalaAsientos()
  {
    $this->conexion();

    $query = "SELECT * FROM sala_asientos
    WHERE sala_id=" . $this->sala_id . "
    AND asiento_id=" . $this->asiento_id;
    $sala_asientos = $this->fetchAll($query);

    if (!isset($sala_asientos[0])) {
      return array(
        'notice' => array('text' => "No existe el asiento-sala especificado"));
    }

    return $sala_asientos;
  }

}
