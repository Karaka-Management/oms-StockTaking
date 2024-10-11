<?php

/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\AssetManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use phpOMS\Uri\UriFactory;

/** @var \phpOMS\Views\View $this */
$inventory = $this->data['inventory'] ?? [];

echo $this->data['nav']->render(); ?>
<div class="row">
    <div class="box more-container">
        <label class="more" for="more-settings">
            <span><?= $this->getHtml('Settings'); ?></span>
            <i class="g-icon expand">chevron_right</i>
        </label>
    </div>
</div>

<div class="wf-100 more-container flex">
    <input class="more" id="more-settings" type="checkbox" name="more-container">
    <div class="row more">
        <div class="col-xs-12">
            <div class="box">
                <div class="form-group">
                    <div class="input-control">
                        <div class="form-group input-control">
                            <label for="iStock"><?= $this->getHtml('Stock', 'WarehouseManagement', 'Backend'); ?></label>
                            <select id="iStock" name="stock" data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&stock={#iStock}&type={#iStockType}&location={#iLocation}", "target": "self"}]}]'>
                                <option value="0"><?= $this->getHtml('All', 'WarehouseManagement', 'Backend'); ?>
                                <?php foreach ($inventory->stocks as $stock) : ?>
                                    <option value="<?= $stock->id; ?>"<?= $this->request->getDataInt('stock') === $stock->id ? ' selected' : ''; ?>><?= $this->printHtml($stock->name); ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-control">
                        <div class="form-group input-control">
                            <label for="iType"><?= $this->getHtml('Type', 'WarehouseManagement', 'Backend'); ?></label>
                            <select id="iType" name="type" data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&stock={#iStock}&type={#iType}&location={#iLocation}", "target": "self"}]}]'>
                                <option value="0"><?= $this->getHtml('All', 'WarehouseManagement', 'Backend'); ?>
                                <?php foreach ($inventory->types as $type) : ?>
                                    <option value="<?= $type->id; ?>"<?= $this->request->getDataInt('type') === $type->id ? ' selected' : ''; ?>><?= $this->printHtml($type->name); ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-control">
                        <div class="form-group input-control">
                            <label for="iLocation"><?= $this->getHtml('Location', 'WarehouseManagement', 'Backend'); ?></label>
                            <select id="iLocation" name="location" data-action='[{"listener": "change", "action": [{"key": 1, "type": "redirect", "uri": "{%}&stock={#iStock}&type={#iStockType}&location={#iLocation}", "target": "self"}]}]'>
                                <option value="0"><?= $this->getHtml('All', 'WarehouseManagement', 'Backend'); ?>
                                <?php foreach ($inventory->stocks[0]->locations as $location) : ?>
                                    <option value="<?= $location->id; ?>"<?= $this->request->getDataInt('location') === $location->id ? ' selected' : ''; ?>><?= $this->printHtml($location->name); ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tabview tab-2">
    <div class="box">
        <ul class="tab-links">
            <li><label for="c-tab-1"><?= $this->getHtml('Entry'); ?></label>
            <li><label for="c-tab-2"><?= $this->getHtml('Scan'); ?></label>
            <li><label for="c-tab-3"><?= $this->getHtml('Analysis'); ?></label>
        </ul>
    </div>
    <div class="tab-content">
        <input type="radio" id="c-tab-1" name="tabular-2"<?= empty($this->request->uri->fragment) || $this->request->uri->fragment === 'c-tab-1' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Items', 'ItemManagement', 'Backend'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <div class="slider">
                        <table id="iItemList" class="default sticky">
                            <thead>
                            <tr>
                                <td><?= $this->getHtml('Stock', 'WarehouseManagement', 'Backend'); ?>
                                <td><?= $this->getHtml('Type', 'WarehouseManagement', 'Backend'); ?>
                                <td><?= $this->getHtml('Location', 'WarehouseManagement', 'Backend'); ?>
                                <td>
                                <td><?= $this->getHtml('Number', 'ItemManagement', 'Backend'); ?>
                                    <label for="iItemList-sort-1">
                                        <input type="radio" name="iItemList-sort" id="iItemList-sort-1">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="iItemList-sort-2">
                                        <input type="radio" name="iItemList-sort" id="iItemList-sort-2">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Name', 'ItemManagement', 'Backend'); ?>
                                    <label for="iItemList-sort-3">
                                        <input type="radio" name="iItemList-sort" id="iItemList-sort-3">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="iItemList-sort-4">
                                        <input type="radio" name="iItemList-sort" id="iItemList-sort-4">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td class="wf-100"><?= $this->getHtml('Name', 'ItemManagement', 'Backend'); ?>
                                    <label for="iItemList-sort-5">
                                        <input type="radio" name="iItemList-sort" id="iItemList-sort-5">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="iItemList-sort-6">
                                        <input type="radio" name="iItemList-sort" id="iItemList-sort-6">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td style="min-width: 100px;"><?= $this->getHtml('Quantity', 'WarehouseManagement', 'Backend'); ?>
                            <tbody>
                            <?php $count = 0;
                            foreach ($inventory->items as $key => $value) : ++$count;
                                $url   = UriFactory::build('{/base}/warehouse/stocktaking/item?id=' . $value->id);
                                $image = $value->getFileByTagName('profile_image');
                            ?>
                            <tr>
                                <td>0
                                <td>0
                                <td>0
                                <td><img<?= $image->id === 0 ? '' : ' id="item' . $value->id . '" tabindex="0" data-preview="' . UriFactory::build('{/api}media/export?id=' . $image->id . '&type=html&csrf={$CSRF}') . '"'; ?> alt="<?= $this->getHtml('IMG_alt_item'); ?>" width="30" loading="lazy" class="item-image"
                                        src="<?= $image->id === 0
                                            ? 'Web/Backend/img/logo_grey.png'
                                            : UriFactory::build($image->getPath()); ?>">
                                <td><?= $this->printHtml($value->number); ?>
                                <td><?= $this->printHtml($value->getL11n('name1')->content); ?>
                                <td><?= $this->printHtml($value->getL11n('name2')->content); ?>
                                <td><input name="count" type="number" steps="any">
                            <?php endforeach; ?>
                            <?php if ($count === 0) : ?>
                                <tr><td colspan="9" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                            <?php endif; ?>
                        </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-2" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-2' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-body">
                            <div id="iScanner" style="text-align: center;" data-encoding="utf-8">
                                <div class="form-group cT">
                                    <button><?= $this->getHtml('Camera'); ?></button>
                                </div>
                                <div class="form-group viewport" style="display: inline-block;position:relative;">
                                    <canvas style="position:absolute; left:0; right:0; width:100%; height:100%;"></canvas>
                                    <video id="iItemScan" style="display: block;max-width:100%;max-height:100%;" muted autoplay playsinline></video>
                                </div>
                                <input type="range">

                                <div class="form-group">
                                    <label><?= $this->getHtml('Data'); ?></label>
                                    <input id="iScanData" name="scan" type="text">
                                </div>

                                <div class="form-group">
                                    <label><?= $this->getHtml('Quantity', 'WarehouseManagement', 'Backend'); ?></label>
                                    <input name="quantity" type="number" step="any">
                                </div>
                            </div>
                        </div>
                        <div class="portlet-foot">
                            <input type="submit" value="<?= $this->getHtml('Submit', '0', '0'); ?>">
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <input type="radio" id="c-tab-3" name="tabular-2"<?= $this->request->uri->fragment === 'c-tab-3' ? ' checked' : ''; ?>>
        <div class="tab">
            <div class="row">
                <div class="col-xs-12">
                    <section class="portlet">
                        <div class="portlet-head"><?= $this->getHtml('Items', 'ItemManagement', 'Backend'); ?><i class="g-icon download btn end-xs">download</i></div>
                        <div class="slider">
                        <table id="iAnalysisList" class="default sticky">
                            <thead>
                            <tr>
                                <td><?= $this->getHtml('Stock', 'WarehouseManagement', 'Backend'); ?>
                                <td><?= $this->getHtml('Type', 'WarehouseManagement', 'Backend'); ?>
                                <td>
                                <td><?= $this->getHtml('Number', 'ItemManagement', 'Backend'); ?>
                                    <label for="iAnalysisList-sort-1">
                                        <input type="radio" name="iAnalysisList-sort" id="iAnalysisList-sort-1">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="iAnalysisList-sort-2">
                                        <input type="radio" name="iAnalysisList-sort" id="iAnalysisList-sort-2">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Name', 'ItemManagement', 'Backend'); ?>
                                    <label for="iAnalysisList-sort-3">
                                        <input type="radio" name="iAnalysisList-sort" id="iAnalysisList-sort-3">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="iAnalysisList-sort-4">
                                        <input type="radio" name="iAnalysisList-sort" id="iAnalysisList-sort-4">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td class="wf-100"><?= $this->getHtml('Name', 'ItemManagement', 'Backend'); ?>
                                    <label for="iAnalysisList-sort-5">
                                        <input type="radio" name="iAnalysisList-sort" id="iAnalysisList-sort-5">
                                        <i class="sort-asc g-icon">expand_less</i>
                                    </label>
                                    <label for="iAnalysisList-sort-6">
                                        <input type="radio" name="iAnalysisList-sort" id="iAnalysisList-sort-6">
                                        <i class="sort-desc g-icon">expand_more</i>
                                    </label>
                                    <label>
                                        <i class="filter g-icon">filter_alt</i>
                                    </label>
                                <td><?= $this->getHtml('Counted'); ?>
                                <td><?= $this->getHtml('Target'); ?>
                            <tbody>
                            <?php $count = 0;
                            foreach ($inventory->items as $key => $value) : ++$count;
                                $url   = UriFactory::build('{/base}/warehouse/stocktaking/item?id=' . $value->id);
                                $image = $value->getFileByTagName('profile_image');
                            ?>
                            <tr>
                                <td>0
                                <td>0
                                <td><img<?= $image->id === 0 ? '' : ' id="itemAnalysis' . $value->id . '" tabindex="0" data-preview="' . UriFactory::build('{/api}media/export?id=' . $image->id . '&type=html&csrf={$CSRF}') . '"'; ?> alt="<?= $this->getHtml('IMG_alt_item'); ?>" width="30" loading="lazy" class="item-image"
                                        src="<?= $image->id === 0
                                            ? 'Web/Backend/img/logo_grey.png'
                                            : UriFactory::build($image->getPath()); ?>">
                                <td><?= $this->printHtml($value->number); ?>
                                <td><?= $this->printHtml($value->getL11n('name1')->content); ?>
                                <td><?= $this->printHtml($value->getL11n('name2')->content); ?>
                                <td>0
                                <td>0
                            <?php endforeach; ?>
                            <?php if ($count === 0) : ?>
                                <tr><td colspan="9" class="empty"><?= $this->getHtml('Empty', '0', '0'); ?>
                            <?php endif; ?>
                        </table>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
</div>