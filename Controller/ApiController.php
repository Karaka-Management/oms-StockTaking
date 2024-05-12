<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\StockTaking
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\StockTaking\Controller;

use Modules\ItemManagement\Models\NullItem;
use Modules\StockTaking\Models\StockTaking;
use Modules\StockTaking\Models\StockTakingMapper;
use Modules\WarehouseManagement\Models\NullStock;
use Modules\WarehouseManagement\Models\NullStockType;
use Modules\WarehouseManagement\Models\Stock;
use Modules\WarehouseManagement\Models\StockDistributionMapper;
use Modules\WarehouseManagement\Models\StockMapper;
use Modules\WarehouseManagement\Models\StockType;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * Budgeting controller class.
 *
 * @package Modules\StockTaking
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Api method to create item payment type
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiStockTakingCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateStockTakingCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $stockTaking = $this->createStockTakingFromRequest($request);
        $this->createModel($request->header->account, $stockTaking, StockTakingMapper::class, 'stocktaking', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $stockTaking);
    }

    /**
     * Validate payment create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateStockTakingCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['unit'] = !$request->hasData('unit'))) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create payment from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return StockTaking
     *
     * @since 1.0.0
     * @todo Implement a function which allows us to add stocks/locations/items to an existing stock taking (admin)
     * @todo Implement a function which allows us to add items to a stock taking (user)
     */
    private function createStockTakingFromRequest(RequestAbstract $request) : StockTaking
    {
        // @todo We started to find item->stock associations by using stock distributions
        //      In the future we MUST change this and create a separate table for item->stock->location->sodium_crypto_aead_chacha20poly1305_ietf_decrypt
        //      association.
        //      It is a little bit unfortunate that we cannot use attributes but it is what it is.

        // Get distributions based on type and stock filter
        $stockTypeList = $request->getDataList('types');
        $stockList     = $request->getDataList('stocks');

        $stockMapper = StockMapper::getAll()
            ->with('locations')
            ->with('locations/type')
            ->where('unit', (int) $request->getData('unit'));

        if (!empty($stockTypeList)) {
            $stockMapper->where('locations/type', $stockTypeList);
        }

        if (!empty($stockList)) {
            $stockMapper->where('id', $stockList);
        }

        /** @var \Modules\WarehouseManagement\Models\Stock[] $stocks */
        $stocks = $stockMapper->executeGetArray();

        foreach ($stocks as $idx => $stock) {
            if (empty($stock->locations)) {
                unset($stocks[$idx]);
            }

            if (empty($stockTypeList)) {
                foreach ($stock->locations as $location) {
                    if ($location->type->id !== 0) {
                        $stockTypeList[$location->type->id] = $location->type->id;
                    }
                }
            }

            if (empty($stockList)) {
                $stockList[] = $stock->id;
            }
        }

        $stocktaking       = new StockTaking();
        $stocktaking->unit = (int) $request->getData('unit');

        $stocktaking->stocks = \array_map(function (int $id) : Stock {
            return new NullStock($id);
        }, $stockList);

        $stocktaking->types = \array_map(function (int $id) : StockType {
            return new NullStockType($id);
        }, $stockTypeList);

        // @todo In the future create create a snapshot of distributions and reference those
        //      This would also allow us to continue creating bills while doing the stocktaking?

        // @todo Limit items if items are defined
        $stocktaking->distributions = StockDistributionMapper::getAll()
            ->where('stock', $stockList)
            ->where('stockType', $stockTypeList)
            ->executeGetArray();

        // @bug This doesn't include items that never had a distribution created
        foreach ($stocktaking->distributions as $distribution) {
            $stocktaking->items[$distribution->item] = new NullItem($distribution->item);
        }

        return $stocktaking;
    }
}
