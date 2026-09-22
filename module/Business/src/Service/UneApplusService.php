<?php

namespace Business\Service;

use Laminas\Db\Adapter\Adapter;
use Business\Model\AppUsuariosTable;

/**
 * Description of UneApplusService
 *
 * @author Gerardo.Caldas
 */

class UneApplusService {
    private $appUsuariosTable;
    private $adapter;
    private $mainConfig;

    public function __construct(Adapter $adapter, AppUsuariosTable $appUsu, $config) {
        $this->adapter = $adapter;
        $this->appUsuariosTable = $appUsu;
        $this->mainConfig = $config;
    }

    /**
     * Valida usuario y contraseña.
     *
     * @param string $codUsuario
     * @param string $password
     * @return int
     */
    public function validaUsuario(string $codUsuario, string $password): int
    {
        $result = $this->adapter->query(
            'SELECT pkg_app_seguridad.ft_valida_usuario(?, ?) AS resultado',
            [trim($codUsuario), $password]
        );

        return (int) $result->current()['resultado'];
    }

    /**
     * Devuelve el ACL (WINDOW, CONTROL, STATUS) del usuario. Si no tiene
     * credenciales asignadas o la función reporta un error, devuelve vacío.
     *
     * @param string $codUsuario
     * @return array
     */
    public function obtieneAclUsuario(string $codUsuario): array
    {
        $result = $this->adapter->query(
            'SELECT pkg_app_seguridad.ft_usuario_acl(?) AS resultado',
            [trim($codUsuario)]
        );

        $data = json_decode((string) $result->current()['resultado'], true);

        if (!is_array($data) || isset($data['OK'])) {
            return [];
        }

        return $data;
    }

    /**
     * Actualiza la contraseña de un usuario, validando la contraseña actual.
     *
     * @param string $codUsuario
     * @param string $passwordActual
     * @param string $passwordNuevo
     * @return int
     */
    public function actualizaPassword(string $codUsuario, string $passwordActual, string $passwordNuevo): int
    {
        $result = $this->adapter->query(
            'SELECT pkg_app_seguridad.ft_actualiza_password(?, ?, ?) AS resultado',
            [trim($codUsuario), $passwordActual, $passwordNuevo]
        );

        return (int) $result->current()['resultado'];
    }

    /**
     * Actualiza los datos de perfil de un usuario.
     *
     * @param string $codUsuario
     * @param string $apellidoPaterno
     * @param string $apellidoMaterno
     * @param string $nombreUsuario
     * @param string $numeroCelular
     * @param string $correoElectronico
     * @param int $codigoEstado
     * @param int $tipoUsuario
     * @return int
     */
    public function actualizaUsuario(
        string $codUsuario,
        string $apellidoPaterno,
        string $apellidoMaterno,
        string $nombreUsuario,
        string $numeroCelular,
        string $correoElectronico,
        int $codigoEstado,
        int $tipoUsuario
    ): int {
        $result = $this->adapter->query(
            'SELECT pkg_app_seguridad.ft_actualiza_usuario(?, ?, ?, ?, ?, ?, ?, ?) AS resultado',
            [
                trim($codUsuario),
                $apellidoPaterno,
                $apellidoMaterno,
                $nombreUsuario,
                $numeroCelular,
                $correoElectronico,
                $codigoEstado,
                $tipoUsuario,
            ]
        );

        return (int) $result->current()['resultado'];
    }

    /**
     * Registra un nuevo usuario.
     *
     * @param string $codUsuario
     * @param string $password
     * @param string $apellidoPaterno
     * @param string $apellidoMaterno
     * @param string $nombreUsuario
     * @param string $numeroCelular
     * @param string $correoElectronico
     * @param int $tipoUsuario
     * @return int
     */
    public function registraUsuario(
        string $codUsuario,
        string $password,
        string $apellidoPaterno,
        string $apellidoMaterno,
        string $nombreUsuario,
        string $numeroCelular,
        string $correoElectronico,
        int $tipoUsuario
    ): int {
        $result = $this->adapter->query(
            'SELECT pkg_app_seguridad.ft_registra_usuario(?, ?, ?, ?, ?, ?, ?, ?) AS resultado',
            [
                trim($codUsuario),
                $password,
                $apellidoPaterno,
                $apellidoMaterno,
                $nombreUsuario,
                $numeroCelular,
                $correoElectronico,
                $tipoUsuario,
            ]
        );

        return (int) $result->current()['resultado'];
    }
}