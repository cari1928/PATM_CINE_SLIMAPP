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
   * LISTADO DE Colaboradores, sin limite de tiempo
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

  /**
   * LISTADO DE Colaboradores, sin limite de tiempo
   * @return array
   */
  public function getListadoCApp()
  {
    $this->conexion();
    $query = "SELECT DISTINCT c.colaborador_id, c.nombre, c.apellidos FROM funcion f
    INNER JOIN pelicula p ON p.pelicula_id = f.pelicula_id
    INNER JOIN reparto r ON r.pelicula_id = p.pelicula_id
    INNER JOIN colaborador c ON c.colaborador_id = r.colaborador_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
    return $this->fetchAll($query);
  }

}
