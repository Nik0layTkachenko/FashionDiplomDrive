<?php

namespace deliveryplugin\Ukrposhta\Validators;

class OptionsValidator
{
  public function validateRequest($data)
  {
    $errors = [];

    if ( ! isset($data['morkva_ukrposhta']['up_method_title']) || strlen($data['morkva_ukrposhta']['up_method_title']) === 0) {
      $errors['morkva_ukrposhta_up_method_title'] = 'Заповніть поле';
    }

    if ( ! isset($data['morkva_ukrposhta']['up_address_title']) || strlen($data['morkva_ukrposhta']['up_address_title']) === 0) {
      $errors['morkva_ukrposhta_up_address_title'] = 'Заповніть поле';
    }

    return $errors ? $errors : true;
  }
}
