<?php

/* 
 *  Copyright (C) 2026 - GCode Software.
 *  Departamento de tecnologias de Informacion - TI
 *  gcaldas - 22 sept. 2026
 */

namespace Business\Model;

class AppUsuariosEntity
{
    public $ID_USUARIO;
    public $CODIGO_USUARIO;
    public $PASSWORD;
    public $APELLIDO_PATERNO;
    public $APELLIDO_MATERNO;
    public $NOMBRE_USUARIO;
    public $NUMERO_CELULAR;
    public $CORREO_ELECTRONICO;
    public $CODIGO_ESTADO;
    public $TIPO_USUARIO;
    public $FECHA_CREACION;

    public function exchangeArray(array $data)
    {
        $this->ID_USUARIO = $data['ID_USUARIO'] ?? null;
        $this->CODIGO_USUARIO = $data['CODIGO_USUARIO'] ?? null;
        $this->PASSWORD = $data['PASSWORD'] ?? null;
        $this->APELLIDO_PATERNO = $data['APELLIDO_PATERNO'] ?? null;
        $this->APELLIDO_MATERNO = $data['APELLIDO_MATERNO'] ?? null;
        $this->NOMBRE_USUARIO = $data['NOMBRE_USUARIO'] ?? null;
        $this->NUMERO_CELULAR = $data['NUMERO_CELULAR'] ?? null;
        $this->CORREO_ELECTRONICO = $data['CORREO_ELECTRONICO'] ?? null;
        $this->CODIGO_ESTADO = $data['CODIGO_ESTADO'] ?? null;
        $this->TIPO_USUARIO = $data['TIPO_USUARIO'] ?? null;
        $this->FECHA_CREACION = $data['FECHA_CREACION'] ?? null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}