<?php

/**
 *
 */
class Funcion extends SlimApp
{
  private $funcion_id  = null;
  private $pelicula_id = null;
  private $datos       = array(); //especificar array para que funcione

  /**
   * GETTERS
   */
  public function getFuncionId()
  {
    return $this->funcion_id;
  }

  public function getPeliculaId()
  {
    return $this->pelicula_id;
  }

  /**
   * SETTERS
   */
  public function setFuncionId($funcion_id)
  {
    $this->funcion_id = $funcion_id;
  }

  public function setPeliculaId($pelicula_id)
  {
    $this->pelicula_id = $pelicula_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE FUNCIONES
   * @return array
   */
  public function getListadoF()
  {
    $this->conexion();

    $query = "SELECT * FROM funcion
    WHERE pelicula_id=" . $this->pelicula_id .
      " ORDER BY sala_id";
    $funciones = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($funciones); $i++) {
      $sala = new Sala;
      $sala->setSalaId($funciones[$i]['sala_id']);
      $funciones[$i]['sala'] = $sala->getSala(); //ya incluye la sucursal
    }

    return $funciones;
  }

  /**
   * OBTIENE UNA FUNCION EN BASE A PELICULA_ID
   * @return array
   */
  public function getFuncion()
  {
    $this->conexion();

    $query   = "SELECT * FROM funcion WHERE pelicula_id=" . $this->pelicula_id;
    $funcion = $this->fetchAll($query);

    if (!isset($funcion[0])) {
      return array('notice' => array('text' => "No existe el funcion especificado"));
    }

    $sala = new Sala;
    $sala->setSalaId($funcion[0]['sala_id']);
    $funcion[0]['sala'] = $sala->getSala();

    return $funcion;
  }

  /**
   * OBTIENE UNA FUNCION EN BASE A FUNCION_ID
   * @return array
   */
  public function getFuncionById()
  {
    $this->conexion();

    $query   = "SELECT * FROM funcion WHERE funcion_id=" . $this->funcion_id;
    $funcion = $this->fetchAll($query);

    if (!isset($funcion[0])) {
      return array('notice' => array('text' => "No existe el funcion especificado"));
    }

    $sala = new Sala;
    $sala->setSalaId($funcion[0]['sala_id']);
    $funcion[0]['sala'] = $sala->getSala();

    return $funcion;
  }

}
