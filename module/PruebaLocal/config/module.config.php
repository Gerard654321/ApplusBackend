<?php
return [
    'service_manager' => [
        'factories' => [
            \PruebaLocal\V1\Rest\Productos\ProductosResource::class => \PruebaLocal\V1\Rest\Productos\ProductosResourceFactory::class,
            \PruebaLocal\V1\Rest\Productos\ProductosTable::class => \PruebaLocal\V1\Rest\Productos\ProductosTableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'prueba-local.rest.productos' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/productos[/:productos_id]',
                    'defaults' => [
                        'controller' => 'PruebaLocal\\V1\\Rest\\Productos\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'prueba-local.rest.productos',
        ],
    ],
    'api-tools-rest' => [
        'PruebaLocal\\V1\\Rest\\Productos\\Controller' => [
            'listener' => \PruebaLocal\V1\Rest\Productos\ProductosResource::class,
            'route_name' => 'prueba-local.rest.productos',
            'route_identifier_name' => 'productos_id',
            'collection_name' => 'productos',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \PruebaLocal\V1\Rest\Productos\ProductosEntity::class,
            'collection_class' => \PruebaLocal\V1\Rest\Productos\ProductosCollection::class,
            'service_name' => 'Productos',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'PruebaLocal\\V1\\Rest\\Productos\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'PruebaLocal\\V1\\Rest\\Productos\\Controller' => [
                0 => 'application/vnd.prueba-local.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'PruebaLocal\\V1\\Rest\\Productos\\Controller' => [
                0 => 'application/vnd.prueba-local.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \PruebaLocal\V1\Rest\Productos\ProductosEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'prueba-local.rest.productos',
                'route_identifier_name' => 'productos_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \PruebaLocal\V1\Rest\Productos\ProductosCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'prueba-local.rest.productos',
                'route_identifier_name' => 'productos_id',
                'is_collection' => true,
            ],
        ],
    ],
];
