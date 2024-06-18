<?php

namespace deliveryplugin\Ukrposhta\classes;

class UPTranslator
{
  private $areaTranslates = [
  ];

  /**
   * @return array
   */
  public function getTranslates()
  {
    return apply_filters('morkva_ukrposhta_get_ukr_poshta_translates', [
      'method_title' => __(morkva_ukrposhta_get_option('morkva_ukrposhta_up_method_title'), 'wc-ukrposhta'),
      'block_title' => __(morkva_ukrposhta_get_option('morkva_ukrposhta_up_block_title'), 'wc-ukrposhta'),
      'placeholder_area' => __(morkva_ukrposhta_get_option('morkva_ukrposhta_up_placeholder_area'), 'wc-ukrposhta'),
      'placeholder_city' => __(morkva_ukrposhta_get_option('morkva_ukrposhta_up_placeholder_city'), 'wc-ukrposhta'),
      'placeholder_warehouse' => __(morkva_ukrposhta_get_option('morkva_ukrposhta_up_placeholder_warehouse'), 'wc-ukrposhta'),
      'address_title' => __(morkva_ukrposhta_get_option('morkva_ukrposhta_up_address_title'), 'wc-ukrposhta'),
      'address_placeholder' => __(morkva_ukrposhta_get_option('morkva_ukrposhta_up_address_placeholder'), 'wc-ukrposhta')
    ]);
  }

  public function translateAreas($areas)
  {
    if (apply_filters('morkva_ukrposhta_language', get_option('morkva_ukrposhta_up_lang', 'ru')) === 'ru') {
      foreach ($areas as &$area) {
        if (isset($this->areaTranslates[ $area['ref'] ])) {
          $area['description'] = $this->areaTranslates[ $area['ref'] ];
        }
      }
    }

    return $areas;
  }
}
