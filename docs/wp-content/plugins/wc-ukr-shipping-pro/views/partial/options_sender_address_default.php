<div class="wcus-control-group">
  <div class="wcus-control-group__title">Адрес отправителя по-умолчанию</div>
  <div class="wcus-control-group__content">

    <div class="wcus-form-group">
      <label>Населенный пункт</label>
      <?php \kirillbdev\WCUkrShipping\Helpers\HtmlHelper::renderSettlementControl('wcus_options_settlement', [
        'settlement_name' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_settlement_name'),
        'settlement_area' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_settlement_area'),
        'settlement_region' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_settlement_region'),
        'settlement_ref' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_settlement_ref'),
        'settlement_full' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_settlement_full')
      ]); ?>
    </div>

    <div class="wcus-form-group">
      <label>Улица</label>
      <?php \kirillbdev\WCUkrShipping\Helpers\HtmlHelper::renderStreetControl('wcus_options_street', [
        'street_name' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_street_name'),
        'street_ref' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_street_ref'),
        'street_full' => wc_ukr_shipping_get_option('wc_ukr_shipping_np_street_full')
      ]); ?>
    </div>

    <div class="wcus-form-group">
      <label for="wcus_options_house">Номер дома</label>
      <input type="text" id="wcus_options_house" class="wcus-form-control" name="wc_ukr_shipping[np_house]" value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_house'); ?>">
    </div>

    <div class="wcus-form-group">
      <label for="wcus_options_flat">Квартира</label>
      <input type="text" id="wcus_options_flat" class="wcus-form-control" name="wc_ukr_shipping[np_flat]" value="<?= wc_ukr_shipping_get_option('wc_ukr_shipping_np_flat'); ?>">
    </div>

  </div>
</div>