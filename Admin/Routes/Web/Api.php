<?php declare(strict_types=1);

use Modules\StockTaking\Controller\ApiController;
use Modules\StockTaking\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/warehouse/stocktaking$' => [
        [
            'dest'       => '\Modules\StockTaking\Controller\ApiController:apiStockTakingCreate',
            'verb'       => RouteVerb::PUT,
            'permission' => [
                'module' => ApiController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_TAKING_ADMINISTRATION,
            ],
        ],
    ],
    '^.*/warehouse/stocktaking/entry$' => [
        [
            'dest'       => '\Modules\StockTaking\Controller\ApiController:apiStockTakingEntryCreate',
            'verb'       => RouteVerb::SET,
            'permission' => [
                'module' => ApiController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_TAKING_ADMINISTRATION,
            ],
        ],
    ],
];
