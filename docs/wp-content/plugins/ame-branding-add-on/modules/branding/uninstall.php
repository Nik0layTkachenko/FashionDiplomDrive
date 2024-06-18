<?php
//Remove branding settings.
if ( defined('ABSPATH') && defined('WP_UNINSTALL_PLUGIN') ) {
	delete_option('ws_ame_general_branding');
	delete_site_option('ws_ame_general_branding');
}