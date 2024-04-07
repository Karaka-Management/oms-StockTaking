<?php
declare(strict_types=1);

use Modules\StockTaking\Controller\BackendController;
use Modules\StockTaking\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/warehouse/stocktaking/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\StockTaking\Controller\BackendController:viewStockTakingList',
            'verb'       => RouteVerb::GET,
            'active' => true,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_TAKING_ADMINISTRATION,
            ],
        ],
    ],
    '^/warehouse/stocktaking/overview(\?.*$|$)' => [
        [
            'dest'       => '\Modules\StockTaking\Controller\BackendController:viewStockTakingOverview',
            'verb'       => RouteVerb::GET,
            'active' => true,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_TAKING_ADMINISTRATION,
            ],
        ],
    ],
    '^/warehouse/stocktaking/area(\?.*$|$)' => [
        [
            'dest'       => '\Modules\StockTaking\Controller\BackendController:viewStockTakingArea',
            'verb'       => RouteVerb::GET,
            'active' => true,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_TAKING_ADMINISTRATION,
            ],
        ],
    ],
    '^/warehouse/stocktaking/entry(\?.*$|$)' => [
        [
            'dest'       => '\Modules\StockTaking\Controller\BackendController:viewStockTakingEntry',
            'verb'       => RouteVerb::GET,
            'active' => true,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_TAKING_ADMINISTRATION,
            ],
        ],
    ],
    '^/warehouse/stocktaking/stats(\?.*$|$)' => [
        [
            'dest'       => '\Modules\StockTaking\Controller\BackendController:viewStockTakingStats',
            'verb'       => RouteVerb::GET,
            'active' => true,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_TAKING_ADMINISTRATION,
            ],
        ],
    ],
];
