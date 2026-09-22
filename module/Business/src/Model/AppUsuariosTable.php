<?php

namespace Business\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSetInterface;

/**
 * Description of AppUsuariosTable
 *
 * @author gcaldas
 */
class AppUsuariosTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Devuelve un registro en base al CODIGO_USUARIO
     *
     * @param string $codigoUsuario
     * @return ResultSetInterface
     */
    public function getByCodigo(string $codigoUsuario): ResultSetInterface
    {
        return $this->tableGateway->select(['CODIGO_USUARIO' => trim($codigoUsuario)]);
    }

    /**
     * Devuelve los usuarios cuyo TIPO_USUARIO coincide con el indicado.
     *
     * @param int $tipoUsuario
     * @return ResultSetInterface
     */
    public function getByTipoUsuario(int $tipoUsuario): ResultSetInterface
    {
        return $this->tableGateway->select(['TIPO_USUARIO' => $tipoUsuario]);
    }
}