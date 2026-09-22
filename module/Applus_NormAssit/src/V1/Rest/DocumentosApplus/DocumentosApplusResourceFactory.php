<?php
namespace Applus_NormAssit\V1\Rest\DocumentosApplus;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Business\Model\DocumentsAppTable;

class DocumentosApplusResourceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $documentsAppTable = $container->get(DocumentsAppTable::class);
        return new DocumentosApplusResource($documentsAppTable);
    }
}
