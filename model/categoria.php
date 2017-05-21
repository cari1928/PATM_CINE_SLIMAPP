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
   * LISTADO DE SALAS SIN RESTRICCIÓN DE TIEMPO
   * YA ESTÁ EN ECLIPSE
   * @return array
   */
  public function getListadoC()
  {
    $this->conexion();
    $query = "SELECT * FROM categoria
    INNER JOIN categoria_pelicula ON categoria_pelicula.categoria_id = categoria.categoria_id
    WHERE categoria_pelicula.pelicula_id=" . $this->pelicula_id;
    return $this->fetchAll($query);
  }

  /**
   * LISTADO DE SALAS CON RESTRICCIÓN DE TIEMPO
   * YA ESTÁ EN ECLIPSE
   * @return array
   */
  public function getListSalaByPeli()
  {
    $this->conexion();

    $query = "SELECT * FROM funcion f
    INNER JOIN pelicula p on p.pelicula_id = f.pelicula_id
    INNER JOIN categoria_pelicula cp on cp.pelicula_id = p.pelicula_id
    INNER JOIN categoria c on c.categoria_id = cp.categoria_id
    WHERE now() between fecha AND fecha_fin
    AND (hora > (now()::time) or (now()::time) < (hora_fin - ('00:30:0'::time)))
    AND categoria_pelicula.pelicula_id=" . $this->pelicula_id .
      " ORDER BY c.categoria_id";

    return $this->fetchAll($query);
  }

  /**
   * LISTADO DE SALAS
   * Con limite de tiempo
   * @return array
   */
  public function getListadoCApp()
  {
    $this->conexion();
    $query = "SELECT DISTINCT c.categoria_id, categoria FROM funcion f
    INNER JOIN pelicula p on p.pelicula_id = f.pelicula_id
    INNER JOIN categoria_pelicula cp on cp.pelicula_id = p.pelicula_id
    INNER JOIN categoria c on c.categoria_id = cp.categoria_id
    WHERE now() between fecha AND fecha_fin
    AND (hora > (now()::time) or (now()::time) < (hora_fin - ('00:30:0'::time)))
    ORDER BY c.categoria_id";
    return $this->fetchAll($query);
  }

}
