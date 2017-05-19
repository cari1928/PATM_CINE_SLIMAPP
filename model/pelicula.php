<?php

/**
 *
 */
class Pelicula extends SlimApp
{
  private $pelicula_id = null;
  private $datos       = array(); //especificar array para que funcione

  /**
   * GETTERS
   */
  public function getPeliculaId()
  {
    return $this->pelicula_id;
  }

  /**
   * SETTERS
   */
  public function setPeliculaId($pelicula_id)
  {
    $this->pelicula_id = $pelicula_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE PELICULAS
   * @return array
   */
  public function getListadoP()
  {
    $this->conexion();
    $query     = "SELECT * FROM pelicula ORDER BY titulo";
    $peliculas = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($peliculas); $i++) {
      $funciones = new Funcion;
      $funciones->setPeliculaId($peliculas[$i]['pelicula_id']);
      $peliculas[$i]['funciones'] = $funciones->getListadoF();
    }

    return $peliculas;
  }

  /**
   * OBTIENE UNA PELÍCULA
   * @return array
   */
  public function getPelicula()
  {
    $this->conexion();

    $query = "SELECT * FROM pelicula
    WHERE pelicula_id=" . $this->pelicula_id . " ORDER BY titulo";
    $pelicula = $this->fetchAll($query);

    if (!isset($pelicula[0])) {
      return array('notice' => array('text' => "No existe la pelicula especificado"));
    }

    $funcion = new Funcion;
    $funcion->setPeliculaId($pelicula[0]['pelicula_id']);
    $pelicula[0]['funcion'] = $funcion->getListadoF();

    return $pelicula;
  }

}
