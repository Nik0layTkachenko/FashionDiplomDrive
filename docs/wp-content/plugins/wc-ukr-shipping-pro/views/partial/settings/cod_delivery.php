<div id="wcus-options-cod-delivery" class="wcus-control-group">
    <div class="wcus-control-group__title">Наложенный платеж</div>
    <div class="wcus-control-group__content">
      <div class="wcus-form-group">
          <label for="wcus_cod_payment_id">Метод наложенного платежа</label>
          <select id="wcus_cod_payment_id" name="wcus[cod_payment_id]" v-model="cod.cod_payment_id" class="wcus-form-control">
              <option v-for="method in cod.payment_methods" v-bind:value="method.id">{{ method.name }}</option>
          </select>
      </div>
      <div class="wcus-form-group wcus-form-group--horizontal">
        <label class="wcus-switcher">
          <input type="checkbox" name="wcus[cod_payment_active]" v-model="cod.active" value="1">
          <span class="wcus-switcher__control"></span>
        </label>
        <div class="wcus-control-label">Включить учет наложенного платежа при расчете доставки</div>
      </div>
    </div>
</div>