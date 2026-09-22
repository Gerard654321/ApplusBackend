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
}