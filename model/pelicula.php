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
   * LISTADO DE PELICULAS CUYAS FUNCIONES ESTÁN DENTRO DE UN RANGO DE FECHA
   * Y HORA ACTUALES
   * @return array
   */
  public function getListadoP()
  {
    $this->conexion();
    $query = "SELECT DISTINCT pelicula.pelicula_id, titulo, descripcion, f_lanzamiento, lenguaje, duracion, poster
    FROM pelicula
    INNER JOIN funcion ON funcion.pelicula_id = pelicula.pelicula_id
    WHERE now() BETWEEN fecha AND fecha_fin AND
    (hora > (now()::time) OR
    (now()::time) < (hora_fin - ('00:30:0'::time)))
    ORDER BY titulo";
    $peliculas = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($peliculas); $i++) {
      $funciones = new Funcion;
      $funciones->setPeliculaId($peliculas[$i]['pelicula_id']);
      $peliculas[$i]['funciones'] = $funciones->getListadoF();

      $categorias = new Categoria;
      $categorias->setPeliculaId($peliculas[$i]['pelicula_id']);
      $peliculas[$i]['categorias'] = $categorias->getListadoC();

      $colaboradores = new Colaborador;
      $colaboradores->setPeliculaId($peliculas[$i]['pelicula_id']);
      $peliculas[$i]['colaboradores'] = $colaboradores->getListadoC();
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
    WHERE pelicula_id=" . $this->pelicula_id;
    $pelicula = $this->fetchAll($query);

    if (!isset($pelicula[0])) {
      return array('notice' => array('text' => "No existe la pelicula especificado"));
    }

    $funcion = new Funcion;
    $funcion->setPeliculaId($pelicula[0]['pelicula_id']);
    $pelicula[0]['funcion'] = $funcion->getListadoF();

    $categoria = new Categoria;
    $categoria->setPeliculaId($pelicula[0]['pelicula_id']);
    $pelicula[0]['categoria'] = $categoria->getListadoC();

    $colaborador = new Colaborador;
    $colaborador->setPeliculaId($pelicula[0]['pelicula_id']);
    $pelicula[0]['colaborador'] = $colaborador->getListadoC();

    return $pelicula;
  }

}
