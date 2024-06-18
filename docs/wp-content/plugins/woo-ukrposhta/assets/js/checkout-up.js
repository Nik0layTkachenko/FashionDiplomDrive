'use strict';

(function (jQuery) {

  let jQueryshippingBox = jQuery('#ukrposhta_shippping_fields'), // Доставка на Відділення
      currentCountry;

  let setLoadingState = function () {
    jQueryshippingBox.addClass('wcus-state-loading');
  };

  let unsetLoadingState = function () {
    jQueryshippingBox.removeClass('wcus-state-loading');
  };

  jQuery('.woocommerce-shipping-fields').css('display', 'none'); // Доставка на іншу адресу

  let isukrPoshtaShippingSelected = function () {
    let currentShipping = jQuery('.shipping_method').length > 1 ?
      jQuery('.shipping_method:checked').val() :
      jQuery('.shipping_method').val();


    return currentShipping && currentShipping.match(/^ukrposhta_shippping.+/i);
  };

  let selectShipping = function () {
    if (isukrPoshtaShippingSelected()) {
      if(currentCountry === 'UA'){
        jQuery('#ukrposhta_shippping_fields').css('display', 'block');
        jQuery('.woocommerce-shipping-fields').css('display', 'none');
      }
      else{
        jQuery('#ukrposhta_shippping_fields').css('display', 'none');
        jQuery('.woocommerce-billing-fields').css('display', 'block');
      }
    }
    else {
      jQuery('#ukrposhta_shippping_fields').css('display', 'none');
      jQuery('.woocommerce-shipping-fields').css('display', 'block');
    }
  };

  let disableDefaultBillingFieldsforup = function () {
    if (isukrPoshtaShippingSelected() && morkva_ukrposhta_globals.disableDefaultBillingFields === 'true') {
      //console.log('way1');
      jQuery('#billing_address_1_field').css('display', 'none');
      jQuery('#billing_address_2_field').css('display', 'none');
      jQuery('#billing_city_field').css('display', 'none');
      jQuery('#billing_state_field').css('display', 'none');
      jQuery('#billing_postcode_field').css('display', 'none');
    }
    else {
      //console.log('way2');
      // jQuery('#billing_address_1_field').css('display', 'block');
      // jQuery('#billing_address_2_field').css('display', 'block');
      // jQuery('#billing_city_field').css('display', 'block');
      // jQuery('#billing_state_field').css('display', 'block');
      // jQuery('#billing_postcode_field').css('display', 'block');

    }

    // Set billing_country field value if it is absent on Checkout page
    currentCountry = jQuery('#billing_country').length ? jQuery('#billing_country').val() : 'UA';
    if(currentCountry !== 'UA'){
        jQuery('.woocommerce-billing-fields').css('display', 'block');


        jQuery('#billing_address_1_field').css('display', 'block');
        jQuery('#billing_address_2_field').css('display', 'block');
        jQuery('#billing_city_field').css('display', 'block');
        jQuery('#billing_state_field').css('display', 'block');
        jQuery('#billing_postcode_field').css('display', 'block');
    }
  };

  let serialixe = function(a){
    //console.log('serialize');
    Cookies.set('shipping_country', jQuery('#billing_country').val() );
    Cookies.set('shipping_city', jQuery('#billing_city').val() );
    Cookies.set('up_shipping_postcode', jQuery('#ukrposhta_shippping_warehouse').val() );
    var addr = jQuery('#up_custom_address').attr('checked') || 'unchecked';
    //console.log(addr);
    if(addr == 'unchecked'){
        Cookies.set('up_custom_address',"",-1);
    }
    else{
      Cookies.set('up_custom_address', addr );
    }
    // jQuery('body').trigger('update_checkout'); // What is it?


  }
  let initialize = function () {
    jQuery('#ukrposhta_shippping_warehouse').on('change', function(){
      serialixe();
    });

    jQuery('#ukrposhta_shippping_city').on('change', function(){
      serialixe();
    });

    jQuery('#ukrposhta_shippping_city2').on('change', function(){
      serialixe();
    });
    jQuery('#billing_country').on('change', function(){
      serialixe();
    });
    jQuery('#up_custom_address').on('change', function(){
      serialixe();
    });


    // let jQuerycustomAddressCheckbox = document.getElementById('up_custom_address');

    // let showCustomAddress = function () {

    //   if (jQuerycustomAddressCheckbox.checked) {
    //     jQuery('#nova-poshta-shipping-info').slideUp(400);
    //     jQuery('#up_custom_address_block').slideDown(400);

    //   }
    //   else {
    //     jQuery('#nova-poshta-shipping-info').slideDown(400);
    //     jQuery('#up_custom_address_block').slideUp(400);
    //   }

    //   disableDefaultBillingFieldsforup();

    // };

    // if (jQuerycustomAddressCheckbox) {
    //   showCustomAddress();
    //   jQuerycustomAddressCheckbox.onclick = showCustomAddress;
    // }


  };

  jQuery(function() {
    jQuery('#ukrposhta_shippping_fields').css('display', 'none');

    // jQuery(document.body).bind('update_checkout', function (event, args) {
    jQuery(document.body).on('update_checkout', function (event, args) {
      setLoadingState();
    });

    // jQuery(document.body).bind('updated_checkout', function (event, args) {
    jQuery(document.body).on('updated_checkout', function (event, args) {
      currentCountry = jQuery('#billing_country').length ? jQuery('#billing_country').val() : 'UA';
      selectShipping();
      disableDefaultBillingFieldsforup();
      unsetLoadingState();
    });

    initialize();
  });

  // Postcode number validation for Ukraine
  jQuery('body').on('blur change', '#ukrposhta_shippping_warehouse', function(){
    var billing_country = jQuery('#billing_country').val();
    if ( billing_country == 'UA') {
      var wrapper_warehouse = jQuery(this).closest('.form-row');
      var field_warehouse = jQuery(this).val();
      if( /^\d{5}$/.test( field_warehouse ) ) { // check if contains 5 postcode numbers
        wrapper_warehouse.addClass('woocommerce-validated'); // success
      } else {
        wrapper_warehouse.addClass('woocommerce-invalid'); // error
      }
    }
  });

  // City name number validation
  jQuery('body').on('blur change', '#ukrposhta_shippping_city', function(){
    var wrapper_city = jQuery(this).closest('.form-row');
    var field_city = jQuery(this).val();
    if( /\d/.test( field_city ) || field_city.length < 2 ) { // check if contains at least one number
      wrapper_city.addClass('woocommerce-invalid'); // error
    } else {
      wrapper_city.addClass('woocommerce-validated'); // success
    }
  });

})(jQuery); // (function (jQuery)
