<?php

/**
 *
 */
class Funcion extends SlimApp
{
  private $funcion_id  = null;
  private $pelicula_id = null;
  private $sucursal_id = null;
  private $sala_id     = null;
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

  public function getSalaId()
  {
    return $this->sala_id;
  }

  public function getSucursalId()
  {
    return $this->sucursal_id;
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

  public function setSalaId($pelicula_id)
  {
    $this->pelicula_id = $pelicula_id;
  }

  public function setSucursalId($sucursal_id)
  {
    $this->sucursal_id = $sucursal_id;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * TODO EL LISTADO
   * @return array
   */
  public function getListado()
  {
    $this->conexion();
    $query     = "SELECT * FROM funcion ORDER BY funcion_id DESC";
    $funciones = $this->fetchAll($query);
    for ($i = 0; $i < sizeof($funciones); $i++) {
      $sala = new Sala;
      $sala->setSalaId($funciones[$i]['sala_id']);
      $funciones[$i]['sala'] = $sala->getSala(); //ya incluye la sucursal

      $pelicula = new Pelicula();
      $pelicula->setPeliculaId($funciones[$i]['pelicula_id']);
      $funciones[$i]['pelicula'] = $pelicula->getSimplePelicula();
    }
    return $funciones;
  }

  /**
   * FUNCIONES EN BASE A UNA PELÍCULA ID, SIN RESTRICCIÓN DE TIEMPO
   * @return array
   */
  public function getListadoF()
  {
    $this->conexion();

    $query = "SELECT * FROM funcion
    WHERE pelicula_id=" . $this->pelicula_id . " ORDER BY sala_id";
    $funciones = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($funciones); $i++) {
      $sala = new Sala;
      $sala->setSalaId($funciones[$i]['sala_id']);
      $funciones[$i]['sala'] = $sala->getSala(); //ya incluye la sucursal
    }

    return $funciones;
  }

  /**
   * FUNCIONES EN BASE A UNA SUCURSAL ID, CON RESTRICCIÓN DE TIEMPO
   * @return array
   */
  public function getListadoFunSuc()
  {
    $this->conexion();
    $query = "SELECT DISTINCT funcion_id, pelicula_id, s.sala_id, fecha, hora, fecha_fin, hora_fin
    FROM funcion f
    INNER JOIN sala s ON f.sala_id = s.sala_id
    INNER JOIN sucursal suc ON suc.sucursal_id = s.sucursal_id
    WHERE (now() BETWEEN fecha AND fecha_fin
        -- AND (hora > (now()::time)
        OR (now()::time) < (hora_fin - ('00:30:0'::time)))
        AND suc.sucursal_id=" . $this->sucursal_id;
    $funciones = $this->fetchAll($query);

    for ($i = 0; $i < sizeof($funciones); $i++) {
      $sala = new Sala;
      $sala->setSalaId($funciones[$i]['sala_id']);
      $funciones[$i]['sala'] = $sala->getSala(); //ya incluye la sucursal

      $pelicula = new Pelicula();
      $pelicula->setPeliculaId($funciones[$i]['pelicula_id']);
      $funciones[$i]['pelicula'] = $pelicula->getSimplePelicula();
    }

    return $funciones;
  }

  /**
   * LISTADO DE FUNCIONES, CON LÍMITE DE TIEMPO
   * Usado en especial.php
   * @return [type] [description]
   */
  public function getListFunApp()
  {
    $this->conexion();

    $query = "SELECT * FROM funcion
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time)
    OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
    $funciones = $this->fetchAll($query);

    return $funciones;
  }

  /**
   * OBTIENE FUNCIONES EN BASE A PELICULA_ID, CON RESTRICCIÓN DE TIEMPO
   * @return array
   */
  public function getFuncion()
  {
    $this->conexion();

    $query = "SELECT * FROM funcion
    WHERE now()BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time)
    OR (now()::time) < (hora_fin - ('00:30:0'::time)))
    AND pelicula_id = " . $this->pelicula_id;
    $funcion = $this->fetchAll($query);

    if (!isset($funcion[0])) {
      return array(
        'notice' => array('text' => "No existe la funcion especificada"));
    }

    //no se si esto se utiliza...
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
    $query   = "SELECT * FROM funcion WHERE funcion_id = " . $this->funcion_id;
    $funcion = $this->fetchAll($query);

    if (!isset($funcion[0])) {
      return array('notice' => array('text' => "Noexisteelfuncionespecificado"));
    }

    $sala = new Sala;
    $sala->setSalaId($funcion[0]['sala_id']);
    $funcion[0]['sala'] = $sala->getSala();

    $pelicula = new Pelicula;
    $pelicula->setPeliculaId($funcion[0]['pelicula_id']);
    $funcion[0]['pelicula'] = $pelicula->getSimplePelicula();

    return $funcion;
  }

  /**
   * Inserción
   * @return [type] [description]
   */
  public function insFuncion()
  {
    $this->conexion();
    $this->setTabla('funcion');
    $this->insert($this->datos);
    return $this->datos;
  }

  /**
   * Actualización
   * @return array
   */
  public function updFuncion()
  {
    $this->conexion();
    $this->setTabla('funcion');
    $this->update($this->datos, array('funcion_id' => $this->datos['funcion_id']));
    return $this->datos;
  }

  /**
   * Borrado
   * @return [type] [description]
   */
  public function delFuncion()
  {
    $this->conexion();
    $this->setTabla('funcion');
    $this->delete(array('funcion_id' => $this->funcion_id));
  }

}
