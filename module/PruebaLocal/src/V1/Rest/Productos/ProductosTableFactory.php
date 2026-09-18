<?php
namespace PruebaLocal\V1\Rest\Productos;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ArraySerializableHydrator;

class ProductosTableFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $adapter = $container->get(AdapterInterface::class);

        $resultSet = new HydratingResultSet(
            new ArraySerializableHydrator(),
            new ProductosEntity()
        );

        $tableGateway = new TableGateway('productos', $adapter, null, $resultSet);

        return new ProductosTable($tableGateway);
    }
}
