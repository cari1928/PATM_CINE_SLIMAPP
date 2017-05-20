<?php

/**
 *
 */
class Colaborador extends Slimapp
{

  private $colaborador_id = null;
  private $pelicula_id    = null;
  private $datos          = array();

  /**
   * GETTERS
   */
  public function getColaboradorId()
  {
    return $this->colaborador_id;
  }

  public function getPeliculaId()
  {
    return $this->pelicula_id;
  }

  /**
   * SETTERS
   */
  public function setColaboradorId($colaborador_id)
  {
    $this->colaborador_id = $colaborador_id;
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
   * LISTADO DE SALAS
   * @return array
   */
  public function getListadoC()
  {
    $this->conexion();
    $query = "SELECT * FROM colaborador
    INNER JOIN reparto ON reparto.colaborador_id=colaborador.colaborador_id
    WHERE reparto.pelicula_id=" . $this->pelicula_id;
    return $this->fetchAll($query);
  }

}
