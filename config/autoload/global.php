<?php

declare(strict_types=1);

return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db'                            => [
        'adapters' => [
            'dummy' => [],
        ],
        'driver'   => 'Pdo_Pgsql',
        'database' => getenv('DB_NAME') ?: 'postgres',
        'username' => getenv('DB_USER') ?: null,
        'password' => getenv('DB_PASSWORD') ?: null,
        'hostname' => getenv('DB_HOST') ?: null,
        'port'     => getenv('DB_PORT') ?: '5432',
    ],
];
