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

/**
 * Stock taking
 *
 * @package Modules\StockTaking\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class StockTaking
{
    public int $id = 0;

    public \DateTimeImmutable $createdAt;

    public array $stocks = [];

    public array $types = [];

    public array $items = [];

    public array $distributions = [];

    public int $unit = 0;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
