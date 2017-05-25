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

  /**
   * Inserción
   * @return [type] [description]
   */
  public function insAsientos()
  {
    $this->conexion();
    $this->setTabla('asientos_reservados');
    $this->insert($this->datos);
    return $this->datos;
  }

  /**
   * Actualización
   * @return array
   */
  public function updAsientos()
  {
    $this->conexion();
    $this->setTabla('asientos_reservados');
    $this->update($this->datos, array(
      'cliente_id' => $this->datos['cliente_id'],
      'asiento_id' => $this->datos['asiento_id'],
      'sala_id'    => $this->datos['sala_id'],
    ));
    return $this->datos;
  }

  /**
   * Borrado
   * @return [type] [description]
   */
  public function delAsientos()
  {
    $this->conexion();
    $this->setTabla('asientos_reservados');
    $this->delete(array(
      'cliente_id' => $this->datos['cliente_id'],
      'asiento_id' => $this->datos['asiento_id'],
      'sala_id'    => $this->datos['sala_id'],
    ));
  }

}
