<?php
return [
    'service_manager' => [
        'factories' => [
            \Applus_NormAssit\V1\Rest\ValidacionUsuario\ValidacionUsuarioResource::class => \Applus_NormAssit\V1\Rest\ValidacionUsuario\ValidacionUsuarioResourceFactory::class,
            \Applus_NormAssit\V1\Rest\DocumentosApplus\DocumentosApplusResource::class => \Applus_NormAssit\V1\Rest\DocumentosApplus\DocumentosApplusResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'applus_norm-assit.rest.validacion-usuario' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/applus/validacion-usuario[/:validacion_usuario_id]',
                    'defaults' => [
                        'controller' => 'Applus_NormAssit\\V1\\Rest\\ValidacionUsuario\\Controller',
                    ],
                ],
            ],
            'applus_norm-assit.rest.documentos-applus' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/applus/documentos-applus[/:documentos_applus_id]',
                    'defaults' => [
                        'controller' => 'Applus_NormAssit\\V1\\Rest\\DocumentosApplus\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'applus_norm-assit.rest.validacion-usuario',
            1 => 'applus_norm-assit.rest.documentos-applus',
        ],
    ],
    'api-tools-rest' => [
        'Applus_NormAssit\\V1\\Rest\\ValidacionUsuario\\Controller' => [
            'listener' => \Applus_NormAssit\V1\Rest\ValidacionUsuario\ValidacionUsuarioResource::class,
            'route_name' => 'applus_norm-assit.rest.validacion-usuario',
            'route_identifier_name' => 'validacion_usuario_id',
            'collection_name' => 'validacion_usuario',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Applus_NormAssit\V1\Rest\ValidacionUsuario\ValidacionUsuarioEntity::class,
            'collection_class' => \Applus_NormAssit\V1\Rest\ValidacionUsuario\ValidacionUsuarioCollection::class,
            'service_name' => 'ValidacionUsuario',
        ],
        'Applus_NormAssit\\V1\\Rest\\DocumentosApplus\\Controller' => [
            'listener' => \Applus_NormAssit\V1\Rest\DocumentosApplus\DocumentosApplusResource::class,
            'route_name' => 'applus_norm-assit.rest.documentos-applus',
            'route_identifier_name' => 'documentos_applus_id',
            'collection_name' => 'documentos_applus',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'PUT',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Applus_NormAssit\V1\Rest\DocumentosApplus\DocumentosApplusEntity::class,
            'collection_class' => \Applus_NormAssit\V1\Rest\DocumentosApplus\DocumentosApplusCollection::class,
            'service_name' => 'DocumentosApplus',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Applus_NormAssit\\V1\\Rest\\ValidacionUsuario\\Controller' => 'HalJson',
            'Applus_NormAssit\\V1\\Rest\\DocumentosApplus\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Applus_NormAssit\\V1\\Rest\\ValidacionUsuario\\Controller' => [
                0 => 'application/vnd.applus_norm-assit.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Applus_NormAssit\\V1\\Rest\\DocumentosApplus\\Controller' => [
                0 => 'application/vnd.applus_norm-assit.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Applus_NormAssit\\V1\\Rest\\ValidacionUsuario\\Controller' => [
                0 => 'application/vnd.applus_norm-assit.v1+json',
                1 => 'application/json',
            ],
            'Applus_NormAssit\\V1\\Rest\\DocumentosApplus\\Controller' => [
                0 => 'application/vnd.applus_norm-assit.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Applus_NormAssit\V1\Rest\ValidacionUsuario\ValidacionUsuarioEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'applus_norm-assit.rest.validacion-usuario',
                'route_identifier_name' => 'validacion_usuario_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \Applus_NormAssit\V1\Rest\ValidacionUsuario\ValidacionUsuarioCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'applus_norm-assit.rest.validacion-usuario',
                'route_identifier_name' => 'validacion_usuario_id',
                'is_collection' => true,
            ],
            \Applus_NormAssit\V1\Rest\DocumentosApplus\DocumentosApplusEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'applus_norm-assit.rest.documentos-applus',
                'route_identifier_name' => 'documentos_applus_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializableHydrator::class,
            ],
            \Applus_NormAssit\V1\Rest\DocumentosApplus\DocumentosApplusCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'applus_norm-assit.rest.documentos-applus',
                'route_identifier_name' => 'documentos_applus_id',
                'is_collection' => true,
            ],
        ],
    ],
];
