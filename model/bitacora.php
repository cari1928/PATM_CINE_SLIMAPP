<?php

class Bitacora extends SlimApp
{
  private $persona_id = null;
  private $token      = null;
  private $datos      = array(); //especificar array para que funcione

  /**
   * GETTERS
   */
  public function getPersonaId()
  {
    return $this->persona_id;
  }

  public function getToken()
  {
    return $this->token;
  }

  /**
   * SETTERS
   */
  public function setDatos($datos)
  {
    $this->datos = $datos;
  }

  public function setPersonaId($persona_id)
  {
    $this->persona_id = $persona_id;
  }

  public function setToken($token)
  {
    $this->token = $token;
  }

/**
 * FUNCIONES
 */

  /**
   * Inserción en Bitácora
   * @return array Datos insertados
   */
  public function insAcceso()
  {
    $this->conexion();
    $this->setTabla('bitacora');
    $this->insert($this->datos);
    return $this->datos;
  }

  /**
   * Verifica que el token ingresado esté dentro del límite de tiempo
   * @return boolean Token válido o no, válido=true
   */
  public function validaToken()
  {
    $this->conexion();

    $query = "SELECT * FROM bitacora
    WHERE persona_id=" . $this->persona_id . "
    AND token='" . $this->token . "'
    AND NOW() BETWEEN f_ini and f_final";

    $valida = $this->fetchAll($query);

    if (isset($valida[0])) {
      return true;
    }

    return false;
  }

}
