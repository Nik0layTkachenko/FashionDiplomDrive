<?php

namespace deliveryplugin\Ukrposhta\classes;

class ukrPoshtaRepository
{
  public function getAreas()
  {
    global $wpdb;

    return $wpdb->get_results("SELECT * FROM morkva_ukrposhta_up_areas", ARRAY_A);
  }

  public function getCities($areaRef)
  {
    global $wpdb;

    return $wpdb->get_results("
      SELECT *
      FROM morkva_ukrposhta_up_cities
      WHERE area_ref='" . esc_attr($areaRef) . "'
      ORDER BY description", ARRAY_A
    );
  }

  public function getWarehouses($cityRef)
  {
    global $wpdb;

    return $wpdb->get_results("
      SELECT *
      FROM morkva_ukrposhta_up_warehouses
      WHERE city_ref='" . esc_attr($cityRef) . "'
      ORDER BY number ASC
      ", ARRAY_A
    );
  }

  public function saveAreas($areas)
  {
    global $wpdb;

    $wpdb->query("TRUNCATE morkva_ukrposhta_up_areas");

    foreach ($areas as $area) {
      $wpdb->query("
        INSERT INTO morkva_ukrposhta_up_areas (ref, description)
        VALUES ('{$area['Ref']}', '" . esc_attr($area['Description']) . "')
      ");
    }
  }

  public function saveCities($cities, $page)
  {
    global $wpdb;

    if ($page === 1) {
      $wpdb->query("TRUNCATE morkva_ukrposhta_up_cities");
    }

    foreach ($cities as $city) {
      $wpdb->query("
        INSERT INTO morkva_ukrposhta_up_cities (ref, description, description_ru, area_ref)
        VALUES ('{$city['Ref']}', '" . esc_attr($city['Description']) . "', '" . esc_attr($city['DescriptionRu']) . "', '{$city['Area']}')
      ");
    }
  }

  public function saveWarehouses($warehouses, $page)
  {
    global $wpdb;

    if ($page === 1) {
      $wpdb->query("TRUNCATE morkva_ukrposhta_up_warehouses");
    }

    foreach ($warehouses as $warehouse) {
      $wpdb->query("
        INSERT INTO morkva_ukrposhta_up_warehouses (ref, description, description_ru, city_ref, number)
        VALUES ('{$warehouse['Ref']}', '" . esc_attr($warehouse['Description']) . "', '" . esc_attr($warehouse['DescriptionRu']) . "', '{$warehouse['CityRef']}', '" . (int)$warehouse['Number'] . "')
      ");
    }
  }

  public function dropTables()
  {
  	global $wpdb;

  	$wpdb->query("DROP TABLE IF EXISTS morkva_ukrposhta_up_areas");
	  $wpdb->query("DROP TABLE IF EXISTS morkva_ukrposhta_up_cities");
	  $wpdb->query("DROP TABLE IF EXISTS morkva_ukrposhta_up_warehouses");
  }
}
