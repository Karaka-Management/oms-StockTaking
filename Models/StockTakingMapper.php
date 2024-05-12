<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\WarehouseManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\StockTaking\Models;

use Modules\ItemManagement\Models\ItemMapper;
use Modules\WarehouseManagement\Models\StockDistributionMapper;
use Modules\WarehouseManagement\Models\StockMapper;
use Modules\WarehouseManagement\Models\StockTypeMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * StockTaking mapper class.
 *
 * @package Modules\StockTaking\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of StockTaking
 * @extends DataMapperFactory<T>
 */
final class StockTakingMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'stocktaking_id'         => ['name' => 'stocktaking_id',    'type' => 'int',    'internal' => 'id'],
        'stocktaking_unit'       => ['name' => 'stocktaking_unit', 'type' => 'int', 'internal' => 'unit'],
        'stocktaking_created_at' => ['name' => 'stocktaking_created_at', 'type' => 'DateTimeImmutable', 'internal' => 'createdAt'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'distributions' => [
            'mapper'   => StockDistributionMapper::class,
            'table'    => 'stocktaking_distribution',
            'self'     => 'stocktaking_distribution_stocktaking',
            'external' => 'stocktaking_distribution_distribution',
        ],
        'stocks' => [
            'mapper'   => StockMapper::class,
            'table'    => 'stocktaking_stock',
            'self'     => 'stocktaking_stock_stocktaking',
            'external' => 'stocktaking_stock_stock',
        ],
        'types' => [
            'mapper'   => StockTypeMapper::class,
            'table'    => 'stocktaking_type',
            'self'     => 'stocktaking_type_stocktaking',
            'external' => 'stocktaking_type_type',
        ],
        'items' => [
            'mapper'   => ItemMapper::class,
            'table'    => 'stocktaking_item',
            'self'     => 'stocktaking_item_stocktaking',
            'external' => 'stocktaking_item_item',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'stocktaking';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'stocktaking_id';
}
