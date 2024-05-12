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

use Modules\StockTaking\Models\StockTakingMapper;
use phpOMS\Asset\AssetType;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Budgeting controller class.
 *
 * @package Modules\StockTaking
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTakingList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/StockTaking/Theme/Backend/stocktaking-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1006701001, $request, $response);

        $view->data['list'] = StockTakingMapper::getAll()
            ->where('unit', $this->app->unitId)
            ->execute();

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTakingView(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $head  = $response->data['Content']->head;
        $nonce = $this->app->appSettings->getOption('script-nonce');

        $head->addAsset(AssetType::JSLATE, 'Resources/zxing/zxing.min.js?v=' . $this->app->version, ['nonce' => $nonce, 'type' => 'module']);
        $head->addAsset(AssetType::JSLATE, 'Modules/StockTaking/Controller/Controller.js?v=' . self::VERSION, ['nonce' => $nonce, 'type' => 'module']);

        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/StockTaking/Theme/Backend/stocktaking-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1006701001, $request, $response);

        $view->data['inventory'] = StockTakingMapper::get()
            ->with('stocks')
            ->with('stocks/locations')
            ->with('types')
            ->with('items')
            ->with('items/l11n')
            ->with('items/l11n/type')
            ->with('items/files')
            ->with('items/files/tags')
            ->with('distributions')
            ->where('id', (int) $request->getData('id'))
            ->where('items/l11n/language', $response->header->l11n->language)
            ->where('item/sl11n/type/title', ['name1', 'name2'], 'IN')
            ->where('items/files/tags/name', 'profile_image')
            ->execute();

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTakingOverview(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/StockTaking/Theme/Backend/stocktaking-overview');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1006701001, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTakingArea(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/StockTaking/Theme/Backend/stocktaking-area');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1006701001, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTakingStats(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/StockTaking/Theme/Backend/stocktaking-stats');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1006701001, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTakingEntry(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/StockTaking/Theme/Backend/stocktaking-entry');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1006701001, $request, $response);

        return $view;
    }
}
