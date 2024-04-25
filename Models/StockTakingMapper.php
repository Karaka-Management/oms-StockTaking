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

use Modules\WarehouseManagement\Models\StockDistributionMapper;
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
            'external' => null,
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
