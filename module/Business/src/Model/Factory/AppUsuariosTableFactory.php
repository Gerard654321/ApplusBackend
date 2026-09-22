<?php

/* 
 *  Copyright (C) 2026 - GCode Software.
 *  Departamento de tecnologias de Informacion - TI
 *  Gerardo Caldas - 22 sept. 2026
 */

namespace Business\Model\Factory;

use Business\Model\AppUsuariosEntity;
use Business\Model\AppUsuariosTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;

class AppUsuariosTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new AppUsuariosEntity());

        return new AppUsuariosTable(
            new TableGateway('APP_USUARIOS', $adapter, null, $resultSetPrototype)
        );
    }
}