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
 * Accept status enum.
 *
 * @package Modules\StockTaking\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class StockTakingStatus extends Enum
{
    public const ACTIVE = 1;

    public const CLOSED = 2;
}
