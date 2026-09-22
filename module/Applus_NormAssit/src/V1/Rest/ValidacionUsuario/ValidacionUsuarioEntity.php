<?php
namespace Applus_NormAssit\V1\Rest\ValidacionUsuario;

class ValidacionUsuarioEntity
{
    protected $codigoUsuario;
    protected $password;

    public function __construct($codigoUsuario, $password)
    {
        $this->codigoUsuario = $codigoUsuario;
        $this->password = $password;
    }

    public function getCodigoUsuario()
    {
        return $this->codigoUsuario;
    }

    public function getPassword()
    {
        return $this->password;
    }
}