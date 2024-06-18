<?php

namespace deliveryplugin\Ukrposhta\classes;

class Migrator
{
  private $migrateCallback = [
    'legacy'  => 'migrateFromLegacy',
    '1.0'     => 'migrateFrom10'
  ];

  public function needMigration()
  {
    $version = get_option('MORKVA_UKRPOSHTA_VERSION');

    return $version !== MORKVA_UKRPOSHTA_VERSION;
  }

  public function getOldVersion()
  {
    return get_option('MORKVA_UKRPOSHTA_VERSION', 'legacy');
  }

  public function migrate()
  {
    $dbVersion = get_option('MORKVA_UKRPOSHTA_VERSION', 'legacy');

    if ($dbVersion !== MORKVA_UKRPOSHTA_VERSION) {

      if (is_callable([ $this, $this->migrateCallback[ $dbVersion ]])) {
        call_user_func([ $this, $this->migrateCallback[ $dbVersion ] ]);
      }

      update_option('MORKVA_UKRPOSHTA_VERSION', MORKVA_UKRPOSHTA_VERSION);
    }
  }

  private function updateTablesLegacy()
  {
    global $wpdb;

    $wpdb->query("
      ALTER TABLE morkva_ukrposhta_up_cities
      ADD COLUMN description_ru VARCHAR(255) NOT NULL
      AFTER description
    ");

    $wpdb->query("
      ALTER TABLE morkva_ukrposhta_up_warehouses
      ADD COLUMN description_ru VARCHAR(255) NOT NULL
        AFTER description,
      ADD COLUMN number INT(10) NOT NULL DEFAULT 0
        AFTER city_ref
    ");
  }

  private function migrateFromLegacy()
  {
    $this->updateTablesLegacy();

    delete_option('morkva_ukrposhta_state');
    delete_option('morkva_ukrposhta_db_version');

    global $wpdb;

    $wpdb->query("DELETE FROM " . $wpdb->prefix . "options WHERE option_name LIKE 'woocommerce_ukrposhta_shippping_%_settings'");
  }

  private function migrateFrom10()
  {
    global $wpdb;

    $wpdb->query("
      ALTER TABLE morkva_ukrposhta_up_warehouses
      ADD COLUMN number INT(10) NOT NULL DEFAULT 0
        AFTER city_ref
    ");
  }
}
