<?php

/**
 *
 */
class Categoria extends Slimapp
{

  private $categoria_id = null;
  private $pelicula_id  = null;
  private $datos        = array();

  /**
   * GETTERS
   */
  public function getCategoriaId()
  {
    return $this->categoria_id;
  }

  public function getPeliculaId()
  {
    return $this->pelicula_id;
  }

  /**
   * SETTERS
   */
  public function setCategoriaId($categoria_id)
  {
    $this->categoria_id = $categoria_id;
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
   * YA ESTÁ EN ECLIPSE
   * @return array
   */
  public function getListadoC()
  {
    $this->conexion();
    $query = "SELECT * FROM categoria
    INNER JOIN categoria_pelicula ON categoria_pelicula.categoria_id=categoria.categoria_id
    WHERE categoria_pelicula.pelicula_id=" . $this->pelicula_id;
    return $this->fetchAll($query);
  }

}
