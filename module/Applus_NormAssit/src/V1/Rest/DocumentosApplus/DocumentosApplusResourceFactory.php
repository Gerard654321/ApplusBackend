<?php
namespace Applus_NormAssit\V1\Rest\DocumentosApplus;

class DocumentosApplusResourceFactory
{
    public function __invoke($services)
    {
        return new DocumentosApplusResource();
    }
}
