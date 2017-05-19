<?php

/**
 *
 */
class AsientosReservados extends SlimApp
{
  private $cliente_id = null;
  private $asiento_id = null;
  private $sala_id    = null;
  private $datos      = array(); //especificar array para que funcione

  /**
   * GETTERS
   */
  public function getClienteId()
  {
    return $this->cliente_id;
  }

  public function getAsientoId()
  {
    return $this->pelicula_id;
  }

  public function getSalaId()
  {
    return $this->sala_id;
  }

  /**
   * SETTERS
   */
  public function setClienteId($funcion_id)
  {
    $this->funcion_id = $funcion_id;
  }

  public function setAsientoId($asiento_id)
  {
    $this->asiento_id = $asiento_id;
  }

  public function setSalaId($sala_id)
  {
    $this->sala_id = $sala_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE ASIENTOS RESERVADOS
   * @return array
   */
  public function getListadoAR()
  {
    $this->conexion();
    $query = "SELECT * FROM asientos_reservados ORDER BY last_update";
    return $this->fetchAll($query);
  }

  /**
   * OBTIENE UN ASIENTO RESERVADO
   * @return array
   */
  public function getAsientoReservado()
  {
    $this->conexion();

    $query = "SELECT * FROM asientos_reservados
    WHERE cliente_id=" . $this->cliente_id .
    " AND asiento_id=" . $this->asiento_id .
    " AND sala_id=" . $this->sala_id .
      " ORDER BY last_update";
    $asiento = $this->fetchAll($query);

    if (!isset($asiento[0])) {
      return array('notice' => array('text' => "No existe el asiento especificado"));
    }

    return $asiento;
  }

}
