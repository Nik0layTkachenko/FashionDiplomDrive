<?php

namespace kirillbdev\WCUkrShipping\Helpers;

if (!defined('ABSPATH')) {
    exit;
}

use kirillbdev\WCUkrShipping\DB\NovaPoshtaRepository;

final class HtmlHelper
{
    /**
     * @param string $id
     * @param string $name
     * @param string|null $value
     * @param array $attributes
     *
     * @return string
     */
    public static function getAreaSelectHtml($id, $name, $value = null, $attributes = [])
    {
        $novaPoshtaRepository = new NovaPoshtaRepository();
        $areas = $novaPoshtaRepository->getAreas();

        return self::getSelectHtml(
            $id,
            $name,
            self::mapAddressDataToOptions($areas),
            $value,
            $attributes
        );
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $areaRef
     * @param string|null $value
     * @param array $attributes
     *
     * @return string
     */
    public static function getCitySelectHtml($id, $name, $areaRef = null, $value = null, $attributes = [])
    {
        $novaPoshtaRepository = new NovaPoshtaRepository();
        $cities = $areaRef ? $novaPoshtaRepository->getCities($areaRef) : [];

        return self::getSelectHtml(
            $id,
            $name,
            self::mapAddressDataToOptions($cities),
            $value,
            $attributes
        );
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $cityRef
     * @param string|null $value
     * @param array $attributes
     *
     * @return string
     */
    public static function getWarehouseSelectHtml($id, $name, $cityRef = null, $value = null, $attributes = [])
    {
        $novaPoshtaRepository = new NovaPoshtaRepository();
        $warehouses = $cityRef ? $novaPoshtaRepository->getWarehouses($cityRef) : [];

        return self::getSelectHtml(
            $id,
            $name,
            self::mapAddressDataToOptions($warehouses),
            $value,
            $attributes
        );
    }

    /**
     * @param string $id
     * @param array $params
     */
    public static function renderSettlementControl($id, $params)
    {
        $html = sprintf(
            '<div id="%s_control" class="wcus-search-control">',
            $id
        );

        $html .= sprintf(
            '<input type="hidden" id="%s_name" name="%s_name" value="%s">',
            $id,
            $id,
            isset($params['settlement_name']) ? $params['settlement_name'] : ''
        );

        $html .= sprintf(
            '<input type="hidden" id="%s_area" name="%s_area" value="%s">',
            $id,
            $id,
            isset($params['settlement_area']) ? $params['settlement_area'] : ''
        );

        $html .= sprintf(
            '<input type="hidden" id="%s_region" name="%s_region" value="%s">',
            $id,
            $id,
            isset($params['settlement_region']) ? $params['settlement_region'] : ''
        );

        $html .= sprintf(
            '<input type="hidden" id="%s_ref" name="%s_ref" class="wcus-search-control__value" value="%s">',
            $id,
            $id,
            isset($params['settlement_ref']) ? $params['settlement_ref'] : ''
        );

        $html .= '<div class="wcus-search-control__query-wrap">';

        $html .= sprintf(
            '<input type="text" class="input-text wcus-form-control wcus-search-control__query" id="%s_full" name="%s_full" value="%s" %s>',
            $id,
            $id,
            isset($params['settlement_full']) ? $params['settlement_full'] : '',
            !empty($params['placeholder']) ? 'placeholder="' . $params['placeholder'] . '"' : ''
        );

        $html .= wc_ukr_shipping_import_svg('search.svg');
        $html .= '
      </div>
        <div class="wcus-search-control__results">
        </div>
      </div>
    ';

        echo $html;
    }

    public static function renderStreetControl($id, $params)
    {
        $html = sprintf(
            '<div id="%s_control" class="wcus-search-control">',
            $id
        );

        $html .= sprintf(
            '<input type="hidden" id="%s_name" name="%s_name" value="%s">',
            $id,
            $id,
            isset($params['street_name']) ? $params['street_name'] : ''
        );

        $html .= sprintf(
            '<input type="hidden" id="%s_ref" name="%s_ref" class="wcus-search-control__value" value="%s">',
            $id,
            $id,
            isset($params['street_ref']) ? $params['street_ref'] : ''
        );

        $html .= '<div class="wcus-search-control__query-wrap">';

        $html .= sprintf(
            '<input type="text" id="%s_full" name="%s_full" class="input-text wcus-form-control wcus-search-control__query" value="%s" %s>',
            $id,
            $id,
            isset($params['street_full']) ? $params['street_full'] : '',
            !empty($params['placeholder']) ? 'placeholder="' . $params['placeholder'] . '"' : ''
        );

        $html .= wc_ukr_shipping_import_svg('search.svg');
        $html .= '
      </div>
        <div class="wcus-search-control__results">
        </div>
      </div>
    ';

        echo $html;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private static function mapAddressDataToOptions($data)
    {
        return array_map(function ($item) {
            return [
                'name' => $item['description'],
                'value' => $item['ref']
            ];
        }, $data);
    }

    /**
     * @param string $id
     * @param string $name
     * @param array $options
     * @param string $value
     *
     * @return string
     */
    private static function getSelectHtml($id, $name, $options, $value, $attributes = [])
    {
        $html = sprintf('<select name="%s" id="%s" class="wcus-form-control j-wcus-select-2"', $name, $id);

        if (!empty($attributes['related-element'])) {
            $html .= ' data-related-element="' . $attributes['related-element'] . '"';
        }

        if (!empty($attributes['ajax-action'])) {
            $html .= ' data-ajax-action="' . $attributes['ajax-action'] . '"';
        }

        if (!empty($attributes['empty_placeholder'])) {
            $html .= ' data-empty-placeholder="' . $attributes['empty_placeholder'] . '"';
        }

        $html .= '>';

        foreach ($options as $option) {
            $html .= sprintf(
                '<option value="%s" %s>%s</option>',
                $option['value'],
                $option['value'] === $value ? 'selected' : '',
                $option['name']
            );
        }

        $html .= '</select>';

        return $html;
    }
}