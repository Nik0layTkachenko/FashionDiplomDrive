<?php

namespace deliveryplugin\Ukrposhta\classes;

class OptionsRepository
{
  /**
   * @param string $key
   * @return mixed|null
   */
  public static function getOption($key)
  {
    $defaults = [
      'morkva_ukrposhta_up_method_title'           => 'Uкрпошта',
      'morkva_ukrposhta_up_block_title'            => esc_html__('Дані доставки', 'woo-ukrposhta-pro'),
      'morkva_ukrposhta_up_placeholder_area'       => 'Область',
      'morkva_ukrposhta_up_placeholder_city'       => 'Місто доставки',
      'morkva_ukrposhta_up_placeholder_warehouse'  => 'Індекс відділення',
      'morkva_ukrposhta_up_address_title'          => esc_html__('Доставка на адресу', 'woo-ukrposhta-pro'),
      'morkva_ukrposhta_up_address_placeholder'    => esc_html__('Введіть адресу доставки', 'woo-ukrposhta-pro'),
      'morkva_ukrposhta_up_block_pos'              => 'billing'
    ];

    return get_option($key, isset($defaults[ $key ]) ? $defaults[ $key ] : null);
  }

  public function save($data)
  {
    foreach ($data['morkva_ukrposhta'] as $key => $value) {
      update_option('morkva_ukrposhta_' . $key, sanitize_text_field($value));
    }

    if ( ! isset($data['morkva_ukrposhta']['address_shipping'])) {
      update_option('morkva_ukrposhta_address_shipping', 0);
    }

    if ( ! isset($data['morkva_ukrposhta']['send_statistic'])) {
      update_option('morkva_ukrposhta_send_statistic', 0);
    }

    // Flush WooCommerce Shipping Cache
    delete_option('_transient_shipping-transient-version');
  }

  public function deleteAll()
  {
	  delete_option('_transient_shipping-transient-version');
  }
}
