<div id="wcus-warehouse-shipping-options" class="wcus-control-group">
    <div class="wcus-control-group__title">Стоимость доставки</div>
    <div class="wcus-control-group__content">
        <div class="wcus-form-group">
            <label for="wc_ukr_shipping_np_price_type">Тип стоимости доставки</label>
            <select id="wc_ukr_shipping_np_price_type" name="wc_ukr_shipping[np_price_type]" v-model="warehouse_shipping.calc_type" class="wcus-form-control">
                <option value="fixed">Фиксированная</option>
                <option value="relative_to_total">Относительно суммы заказа</option>
                <option value="calculate">Автоматический просчет</option>
            </select>
        </div>
        <div v-if="'fixed' === warehouse_shipping.calc_type" class="wcus-form-group">
            <label for="wc_ukr_shipping_np_price">Фиксированная стоимость</label>
            <input type="text" id="wc_ukr_shipping_np_price" name="wc_ukr_shipping[np_price]" v-model="warehouse_shipping.fixed_price" class="wcus-form-control">
        </div>
        <div v-if="'calculate' === warehouse_shipping.calc_type" id="wcus-price-auto" class="wcus-form-group">
            <div class="wcus-form-group">
                <label>Тип груза</label>
                <select name="wc_ukr_shipping[np_cargo_type]" v-model="warehouse_shipping.cargo_type" class="wcus-form-control">
                    <option value="Cargo">Вантаж</option>
                    <option value="Documents">Документи</option>
                    <option value="TiresWheels">Шини-диски</option>
                    <option value="Pallet">Палети</option>
                    <option value="Parcel">Посилка</option>
                </select>
            </div>
        </div>
        <relative-cost v-if="'relative_to_total' === warehouse_shipping.calc_type" name="wc_ukr_shipping[np_relative_price]" :items="warehouse_shipping.total_cost"></relative-cost>
    </div>
</div>