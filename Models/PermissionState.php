<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\StockTaking\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\StockTaking\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Permission category enum.
 *
 * @package Modules\StockTaking\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class PermissionState extends Enum
{
    public const STOCK_TAKING_COUNTING = 1;

    public const STOCK_TAKING_ADMINISTRATION = 2;
}
