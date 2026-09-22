<?php

namespace Business\Service\Factory;

use Interop\Container\ContainerInterface;
use Business\Service\UneApplusService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\Adapter\AdapterInterface;

/**
 * Description of UneApplusServiceFactory
 *
 * @author Gerardo Caldas
 */
class UneApplusServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(AdapterInterface::class);
        $config = $container->get('Config');

        return new UneApplusService($adapter, $container->get(\Business\Model\AppUsuariosTable::class), $config);
    }
}