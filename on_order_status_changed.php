<?php

/**
 * on_order_status_changed Chat GPT Creation
 */
function on_order_status_changed($order_id, $old_status, $new_status) {
    $statuses_to_process = array('completed', 'cancelled', 'refunded', 'failed');
    
    if (in_array($new_status, $statuses_to_process)) {
        wc_update_purchase_data_custom_table($order_id);
    }
}

add_action('woocommerce_order_status_changed', 'on_order_status_changed', 10, 3);
