<?php

/*
 *  Copyright (C) 2026 - GCode Software.
 *  Departamento de tecnologias de Informacion - TI
 *  Gerardo Caldas - 22 sept. 2026
 */

namespace Business\Model\Factory;

use Business\Model\DocumentsAppEntity;
use Business\Model\DocumentsAppTable;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;

class DocumentsAppTableFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get(AdapterInterface::class);
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new DocumentsAppEntity());

        return new DocumentsAppTable(
            new TableGateway('DOCUMENTS_APP', $adapter, null, $resultSetPrototype)
        );
    }
}
