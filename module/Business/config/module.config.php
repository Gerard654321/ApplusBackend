<?php

namespace Business;

use Business\Model\AppUsuariosTable;
use Business\Model\Factory\AppUsuariosTableFactory;
use Business\Model\DocumentsAppTable;
use Business\Model\Factory\DocumentsAppTableFactory;
use Business\Service\UneApplusService;
use Business\Service\Factory\UneApplusServiceFactory;

return [
    'service_manager' => [
        'factories' => [
            AppUsuariosTable::class => AppUsuariosTableFactory::class,
            DocumentsAppTable::class => DocumentsAppTableFactory::class,
            UneApplusService::class => UneApplusServiceFactory::class,
        ],
    ],
];
