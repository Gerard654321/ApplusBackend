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

    /**
     * Actualiza los datos de perfil de un usuario.
     * No toca CODIGO_USUARIO, PASSWORD ni FECHA_CREACION.
     *
     * @param string $codigoUsuario
     * @param string $apellidoPaterno
     * @param string $apellidoMaterno
     * @param string $nombreUsuario
     * @param string $numeroCelular
     * @param string $correoElectronico
     * @param int $codigoEstado
     * @param int $tipoUsuario
     * @return int Filas afectadas
     */
    public function updateDatosUsuario(
        string $codigoUsuario,
        string $apellidoPaterno,
        string $apellidoMaterno,
        string $nombreUsuario,
        string $numeroCelular,
        string $correoElectronico,
        int $codigoEstado,
        int $tipoUsuario
    ): int {
        $data = [
            'APELLIDO_PATERNO' => $apellidoPaterno,
            'APELLIDO_MATERNO' => $apellidoMaterno,
            'NOMBRE_USUARIO' => $nombreUsuario,
            'NUMERO_CELULAR' => $numeroCelular,
            'CORREO_ELECTRONICO' => $correoElectronico,
            'CODIGO_ESTADO' => $codigoEstado,
            'TIPO_USUARIO' => $tipoUsuario,
        ];

        return $this->tableGateway->update($data, ['CODIGO_USUARIO' => trim($codigoUsuario)]);
    }
}