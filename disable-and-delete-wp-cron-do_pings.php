<?php

/**
 * Disable and delete wp-cron do_pings
 */
if (isset($_GET['doing_wp_cron'])) {
	remove_action('do_pings', 'do_all_pings');
	wp_clear_scheduled_hook('do_pings');
}
