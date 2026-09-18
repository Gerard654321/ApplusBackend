<?php
namespace PruebaLocal\V1\Rest\Productos;

use Interop\Container\ContainerInterface;

class ProductosResourceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ProductosResource($container->get(ProductosTable::class));
    }
}
