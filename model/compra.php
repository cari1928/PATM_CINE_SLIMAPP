<?php

/**
 *
 */
class Compra extends SlimApp
{
  private $compra_id  = null;
  private $cliente_id = null;
  private $datos      = array(); //especificar array para que funcione

  /**
   * GETTERS
   */
  public function getCompraId()
  {
    return $this->compra_id;
  }

  public function getClienteId()
  {
    return $this->cliente_id;
  }

  /**
   * SETTERS
   */
  public function setCompraId($compra_id)
  {
    $this->compra_id = $compra_id;
  }

  public function setClienteId($cliente_id)
  {
    $this->cliente_id = $cliente_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE COMPRAS
   * @return array
   */
  public function getListadoC()
  {
    $this->conexion();
    $query   = "SELECT * FROM compra ORDER BY compra_id DESC";
    $compras = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($compras); $i++) {
      $funciones = new Funcion;
      $funciones->setFuncionId($compras[$i]['funcion_id']);
      $compras[$i]['funcion'] = $funciones->getFuncionById();
    }

    return $compras;
  }

  /**
   * LISTADO DE COMPRAS DE UN CLIENTE EN ESPECÍFICO
   * @return array
   */
  public function getListadoById()
  {
    $this->conexion();
    $query = "SELECT * FROM compra
    WHERE cliente_id=" . $this->cliente_id .
      " ORDER BY compra_id DESC";
    $compras = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($compras); $i++) {
      $funciones = new Funcion;
      $funciones->setFuncionId($compras[$i]['funcion_id']);
      $compras[$i]['funcion'] = $funciones->getFuncionById();
    }

    return $compras;
  }

  /**
   * OBTIENE UNA COMPRA
   * @return array
   */
  public function getCompra()
  {
    $this->conexion();

    $query  = "SELECT * FROM compra WHERE compra_id=" . $this->compra_id;
    $compra = $this->fetchAll($query);

    if (!isset($compra[0])) {
      return array('notice' => array('text' => "No existe la compra especificado"));
    }

    $funcion = new Funcion;
    $funcion->setFuncionId($compra[0]['funcion_id']);
    $compra[0]['funcion'] = $funcion->getFuncionById();

    return $compra;
  }

  /**
   * INSERTA UNA COMPRA
   * @return array
   */
  public function insCompra()
  {
    $this->conexion();
    $this->setTabla('compra');
    $this->insert($this->datos);
    return $this->datos;
  }

  /**
   * ACTUALIZA UNA COMPRA
   * @return array
   */
  public function updCompra()
  {
    $this->conexion();
    $this->setTabla('compra');
    $this->update($this->datos, array('compra_id' => $this->datos['compra_id']));
    return $this->datos;
  }

  /**
   * ELIMINA UNA COMPRA
   */
  public function delCompra()
  {
    $this->conexion();
    $this->setTabla('compra');
    $this->delete(array('compra_id' => $this->compra_id));
  }

}
