<?php
namespace Applus_NormAssit\V1\Rest\ValidacionUsuario;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Business\Service\UneApplusService;

class ValidacionUsuarioResourceFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $uneApplusService = $container->get(UneApplusService::class);
        return new ValidacionUsuarioResource($uneApplusService);
    }
}