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
   * LISTADO DE SALAS DENTRO DE LAS FECHAS DE LAS FUNCIONES
   * Usado en especial.php
   * @return array
   */
  public function getListApp()
  {
    $this->conexion();
    $query = "SELECT DISTINCT sala.sala_id, nombre, sucursal_id, numero_sala
    FROM sala
    INNER JOIN funcion ON funcion.sala_id = sala.sala_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time)
    OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
    return $this->fetchAll($query);
  }

  /**
   * LISTADO DE SALAS, SIN LÍMITE DE TIEMPO
   * @return array
   */
  public function getListado()
  {
    $this->conexion();
    $query = "SELECT * FROM sala ORDER BY sala_id";
    $salas = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($salas); $i++) {
      $sucursal = new Sucursal;
      $sucursal->setSucursalId($salas[$i]['sucursal_id']);
      $salas[$i]['sucursal'] = $sucursal->getSucursal();
    }

    return $salas;
  }

  /**
   * OBTIENE UNA SALA EN ESPECÍFICO, CON LÍMITE DE TIEMPO
   * @return array
   */
  public function getSalaApp()
  {
    $this->conexion();

    $query = "SELECT DISTINCT sala.sala_id, nombre, sucursal_id, numero_sala
    FROM sala
    INNER JOIN funcion ON funcion.sala_id = sala.sala_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time)
    OR (now()::time) < (hora_fin - ('00:30:0'::time)))
    AND sala_id=" . $this->sala_id;
    $sala = $this->fetchAll($query);

    if (!isset($sala[0])) {
      return array('notice' => array('text' => "No existe el sala especificado"));
    }

    $sucursal = new Sucursal;
    $sucursal->setSucursalId($sala[0]['sucursal_id']);
    $sala[0]['sucursal'] = $sucursal->getSucursal();

    return $sala;
  }

  /**
   * OBTIENE UNA SALA EN ESPECÍFICO, SIN LÍMITE DE TIEMPO
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

  /**
   * INSERTA UNA COMPRA
   * @return array
   */
  public function insSala()
  {
    $this->conexion();
    $this->setTabla('sala');
    $this->insert($this->datos);
    return $this->datos;
  }

  /**
   * ACTUALIZA UNA COMPRA
   * @return array
   */
  public function updSala()
  {
    $this->conexion();
    $this->setTabla('sala');
    $this->update($this->datos, array('sala_id' => $this->datos['sala_id']));
    return $this->datos;
  }

  /**
   * ELIMINA UNA COMPRA
   */
  public function delSala()
  {
    $this->conexion();
    $this->setTabla('sala');
    $this->delete(array('sala_id' => $this->sala_id));
  }

}
