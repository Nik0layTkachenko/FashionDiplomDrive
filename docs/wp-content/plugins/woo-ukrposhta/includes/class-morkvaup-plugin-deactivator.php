<?php
/**
 * Fired during plugin deactivation
 *
 * @link       http://morkva.co.ua/
 * @since      1.0.0
 *
 * @package    morkvaup-plugin
 * @subpackage morkvaup-plugin/includes
 */
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    morkvaup-plugin
 * @subpackage morkvaup-plugin/includes
 * @author     MORKVA <hello@morkva.co.ua>
 */
class MUP_Plugin_Deactivator {
	/**
	 * The code that runs during plugin deactivation
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        flush_rewrite_rules();
	}
}
