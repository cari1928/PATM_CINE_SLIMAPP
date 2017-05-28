<?php

/**
 *
 */
class SalaAsientos extends Slimapp
{

  private $sala_id     = null;
  private $asiento_id  = null;
  private $sucursal_id = null;
  private $funcion_id  = null;
  private $datos       = array();

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

  public function getSucursalId()
  {
    return $this->sucursal_id;
  }

  public function getFuncionId()
  {
    return $this->sucursal_id;
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

  public function setSucursalId($sucursal_id)
  {
    $this->sucursal_id = $sucursal_id;
  }

  public function setFuncionId($funcion_id)
  {
    $this->funcion_id = $funcion_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE SALA-ASIENTOS DESOCUPADOS
   * @return array
   */
  public function getDesocupados()
  {
    $this->conexion();

    $query = "SELECT sa.asiento_id, sa.columna, sa.fila, ar.cliente_id
    FROM sala_asientos sa
    LEFT JOIN asientos_reservados ar ON ar.sala_id = sa.sala_id
    AND ar.asiento_id = sa.asiento_id
    WHERE sa.sala_id IN (
    SELECT sala_id FROM sala WHERE sucursal_id=" . $this->sucursal_id . ")
    AND sa.sala_id = " . $this->sala_id . "
    AND sa.funcion_id = " . $this->funcion_id;
    $asientos = $this->fetchAll($query);

    $libres = array();
    for ($i = 0; $i < sizeof($asientos); $i++) {
      if (empty($asientos[$i]['cliente_id'])) {
        unset($asientos[$i]['cliente_id']);

        $sala = new Sala;
        $sala->setSalaId($this->sala_id);
        $asientos[$i]['sala'] = $sala->getSala();

        array_push($libres, $asientos[$i]);
      }
    }

    return $libres;
  }

  /**
   * LISTADO DE SALA-ASIENTOS DESOCUPADOS
   * @return array
   */
  public function getDesocupadosApp()
  {
    $this->conexion();

    $query = "SELECT sa.asiento_id, sa.columna, sa.fila, ar.cliente_id
    FROM sala_asientos sa
    LEFT JOIN asientos_reservados ar ON ar.sala_id = sa.sala_id
    AND ar.asiento_id = sa.asiento_id
    WHERE sa.sala_id IN (
    SELECT sala_id FROM sala WHERE sucursal_id=" . $this->sucursal_id . ")
    AND sa.sala_id = " . $this->sala_id . "
    AND sa.funcion_id = " . $this->funcion_id;
    $asientos = $this->fetchAll($query);

    $libres = array();
    for ($i = 0; $i < sizeof($asientos); $i++) {
      if (empty($asientos[$i]['cliente_id'])) {
        unset($asientos[$i]['cliente_id']);
        array_push($libres, $asientos[$i]);
      }
    }

    return $libres;
  }

  /**
   * OBTIENE UN ASIENTO DE UNA SALA EN ESPECÍFICO
   * @return array
   */
  public function getSalaAsientos()
  {
    $this->conexion();

    $query = "SELECT * FROMsala_asientos
    WHEREsala_id   = " . $this->sala_id . "
    and asiento_id = " . $this->asiento_id;
    $sala_asientos = $this->fetchAll($query);

    if (!isset($sala_asientos[0])) {
      return array(
        'notice' => array('text' => "Noexisteelasiento - salaespecificado"));
    }

    return $sala_asientos;
  }

  /**
   * INSERTA
   * @return array
   */
  public function insAsiento()
  {
    $this->conexion();
    $this->setTabla('sala_asientos');
    $this->insert($this->datos);
    return $this->datos;
  }

  /**
   * ACTUALIZA
   * @return array
   */
  public function updAsiento()
  {
    $this->conexion();
    $this->setTabla('sala_asientos');
    $this->update($this->datos, array(
      'asiento_id' => $this->datos['asiento_id'],
      'sala_id'    => $this->datos['sala_id'],
    ));
    return $this->datos;
  }

  /**
   * ELIMINA
   */
  public function delAsiento()
  {
    $this->conexion();
    $this->setTabla('sala_asientos');
    $this->delete(array(
      'asiento_id' => $this->datos['asiento_id'],
      'sala_id'    => $this->datos['sala_id'],
    ));
  }

}
