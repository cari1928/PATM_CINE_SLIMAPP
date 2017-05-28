<?php

/**
 * Utilizado por la app
 */
class Especial extends SlimApp
{
  private $pelicula = null;
  private $funcion  = null;
  private $sala     = null;
  private $sucursal = null;
  private $datos    = array(); //especificar array para que funcione

  /**
   * GETTERS
   */
  public function getPelicula()
  {
    return $this->pelicula;
  }

  public function getFuncion()
  {
    return $this->funcion;
  }

  public function getSala()
  {
    return $this->sala;
  }

  public function getSucursal()
  {
    return $this->sucursal;
  }

  /**
   * SETTERS
   */
  public function setPelicula($pelicula)
  {
    $this->pelicula = $pelicula;
  }

  public function setFuncion($funcion)
  {
    $this->funcion = $funcion;
  }

  public function setSala($sala)
  {
    $this->sala = $sala;
  }

  public function setSucursal($sucursal)
  {
    $this->sucursal = $sucursal;
  }

  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  /**
   * LISTADO DE FUNCIONES, CON LÍMITE DE TIEMPO
   */
  public function getListFunApp()
  {
    $this->conexion();

    $funciones = new Funcion;
    $funciones = $funciones->getListFunApp();

    // $this->debug($funciones);

    $peliculas = new Pelicula;
    $peliculas = $peliculas->getListadoPApp();

    $salas = new Sala;
    $salas = $salas->getListApp();

    $sucursales = new Sucursal;
    $sucursales = $sucursales->getListApp();

    $categorias = new Categoria;
    $categorias = $categorias->getListadoCApp();

    $colaboradores = new Colaborador;
    $colaboradores = $colaboradores->getListadoCApp();

    $query = "SELECT DISTINCT cp.categoria_id, cp.pelicula_id,
    cp.categoria_pelicula_id FROM funcion f
    INNER JOIN pelicula p ON p.pelicula_id = f.pelicula_id
    INNER JOIN categoria_pelicula cp ON cp.pelicula_id = p.pelicula_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
    $cat_pelis = $this->fetchAll($query);

    $query = "SELECT r.colaborador_id, r.pelicula_id, r.puesto, r.reparto_id
    FROM funcion f
    INNER JOIN pelicula p ON p.pelicula_id = f.pelicula_id
    INNER JOIN reparto r ON r.pelicula_id = p.pelicula_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
    $repartos = $this->fetchAll($query);

    $datos = array(
      'peliculas'     => $peliculas,
      'funciones'     => $funciones,
      'sucursales'    => $sucursales,
      'salas'         => $salas,
      'categorias'    => $categorias,
      'colaboradores' => $colaboradores,
      'cat_pelis'     => $cat_pelis,
      'repartos'      => $repartos,
    );

    return $datos;
  }

  /**
   * LISTADO DE ASIENTOS DE SALA Y RESERVADOS, CON LÍMITE DE TIEMPO
   */
  public function getListAsiApp()
  {
    $this->conexion();

    $funciones = new Funcion;
    $funciones = $funciones->getListFunApp();

    $peliculas = new Pelicula;
    $peliculas = $peliculas->getListadoPApp();

    $salas = new Sala;
    $salas = $salas->getListApp();

    $sucursales = new Sucursal;
    $sucursales = $sucursales->getListApp();

    $categorias = new Categoria;
    $categorias = $categorias->getListadoCApp();

    $colaboradores = new Colaborador;
    $colaboradores = $colaboradores->getListadoCApp();

    $query = "SELECT DISTINCT cp.categoria_id, cp.pelicula_id,
    cp.categoria_pelicula_id FROM funcion f
    INNER JOIN pelicula p ON p.pelicula_id = f.pelicula_id
    INNER JOIN categoria_pelicula cp ON cp.pelicula_id = p.pelicula_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
    $cat_pelis = $this->fetchAll($query);

    $query = "SELECT r.colaborador_id, r.pelicula_id, r.puesto, r.reparto_id
    FROM funcion f
    INNER JOIN pelicula p ON p.pelicula_id = f.pelicula_id
    INNER JOIN reparto r ON r.pelicula_id = p.pelicula_id
    WHERE now() BETWEEN fecha AND fecha_fin
    AND (hora > (now()::time) OR (now()::time) < (hora_fin - ('00:30:0'::time)))";
    $repartos = $this->fetchAll($query);

    $datos = array(
      'peliculas'     => $peliculas,
      'funciones'     => $funciones,
      'sucursales'    => $sucursales,
      'salas'         => $salas,
      'categorias'    => $categorias,
      'colaboradores' => $colaboradores,
      'cat_pelis'     => $cat_pelis,
      'repartos'      => $repartos,
    );

    return $datos;
  }

}
