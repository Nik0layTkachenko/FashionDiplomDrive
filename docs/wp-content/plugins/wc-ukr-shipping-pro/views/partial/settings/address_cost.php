<div id="wcus-address-shipping-options">
    <div class="wcus-control-group">
        <div class="wcus-control-group__title">Стоимость адресной доставки</div>
        <div class="wcus-control-group__content">
            <div class="wcus-form-group wcus-form-group--horizontal">
                <label class="wcus-switcher">
                    <input type="checkbox" name="wcus[address_calc_enable]" v-model="address_shipping.calc_enable" value="1">
                    <span class="wcus-switcher__control"></span>
                </label>
                <div class="wcus-control-label">Включить отдельную стоимость</div>
            </div>
            <template v-if="address_shipping.calc_enable">
                <div class="wcus-form-group">
                    <label for="wcus_address_shipping_calc_type">Тип стоимости доставки</label>
                    <select id="wcus_address_shipping_calc_type" name="wcus[address_calc_type]" v-model="address_shipping.calc_type" class="wcus-form-control">
                        <option v-for="option in address_shipping.calc_types" v-bind:value="option.value">{{ option.name }}</option>
                    </select>
                </div>
                <?php /* Fixed pane */ ?>
                <div v-if="'fixed' === address_shipping.calc_type" class="wcus-form-group">
                    <label for="wcus_address_fixed_price">Фиксированная стоимость</label>
                    <input type="text" id="wcus_address_fixed_price" name="wcus[address_fixed_cost]" v-model="address_shipping.fixed_cost" class="wcus-form-control">
                </div>
                <?php /* Relative pane */ ?>
                <relative-cost v-if="'total_relative' === address_shipping.calc_type" name="wcus[address_total_cost]" :items="address_shipping.total_cost"></relative-cost>
            </template>
        </div>
    </div>
</div>