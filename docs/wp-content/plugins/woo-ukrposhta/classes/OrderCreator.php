<?php

namespace deliveryplugin\Ukrposhta\classes;

use deliveryplugin\Ukrposhta\Services\StorageService;

if ( ! defined('ABSPATH')) {
  exit;
}

class OrderCreator
{
  public function __construct()
  {
    add_action('woocommerce_checkout_create_order', [ $this, 'createOrder' ]);
  }

  public function createOrder($order)
  {
    // if ($_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_custom_address']) {
    //   $order->set_shipping_address_1(sanitize_text_field($_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_custom_address']));
    //   $order->set_billing_address_1(sanitize_text_field($_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_custom_address']));

    //   if (  $_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_city2']  ) {
    //     $order->set_shipping_city(esc_attr($_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_city2']) );

    //     $order->set_billing_city( esc_attr($_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_city2']) );
    //   }

    //   return;
    // }

    // Save Order city and warehouse data. They will be shown on Thankypage also.
    // Set billing_country field value if it is absent on Checkout page
    $_POST['billing_country'] = isset( $_POST['billing_country'] ) ? $_POST['billing_country'] : 'UA';
    if( 'UA' ==  $_POST['billing_country'] ) {
      if (  $_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_city']  ) {
        $input_city = $_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_city'];
        if ( strpos( $input_city, "'" ) !== false ) {
            $input_city = str_replace( "\\", "", $input_city );
        }
        $input_city_tolower = wc_strtolower( $input_city );
        $input_city_tolower_ucf = mb_convert_case( $input_city_tolower, MB_CASE_TITLE,"UTF-8" );

        $order->set_shipping_city(esc_attr( $input_city_tolower_ucf ) );
        $order->set_billing_city(esc_attr( $input_city_tolower_ucf ) );
        $order->set_shipping_address_1( esc_attr( $input_city_tolower_ucf ) );
      }

      if ( !empty( $_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_warehouse'] )  ) {
        $order->set_shipping_postcode( esc_attr($_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_warehouse']) );
        $order->set_billing_postcode( esc_attr($_POST[MORKVA_UKRPOSHTA_UP_SHIPPING_NAME . '_warehouse']));

      }
    }
    else{

        if (  $_POST['billing_city']  ) {
          $order->set_billing_city(esc_attr($_POST['billing_city']) );
          $order->set_shipping_city( esc_attr($_POST['billing_city']) );
        }

        if (  $_POST['billing_address_1']  ) {
          $order->set_billing_address_1(esc_attr($_POST['billing_address_1']) );
          $order->set_shipping_address_1( esc_attr($_POST['billing_address_1']) );
        }

        if (  $_POST['billing_address_2']  ) {
          $order->set_billing_address_2(esc_attr($_POST['billing_address_2']) );
          $order->set_shipping_address_2( esc_attr($_POST['billing_address_2']) );
        }

        if (  $_POST['billing_state']  ) {
          $order->set_billing_state(esc_attr($_POST['billing_state']) );
          $order->set_shipping_state( esc_attr($_POST['billing_state']) );
        }

        if (  $_POST['billing_postcode']  ) {
          $order->set_shipping_postcode(esc_attr($_POST['billing_postcode']) );
          $order->set_billing_postcode( esc_attr($_POST['billing_postcode']) );
        }

    }



  }
}
