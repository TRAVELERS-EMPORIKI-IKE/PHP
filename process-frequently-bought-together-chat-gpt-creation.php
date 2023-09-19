<?php

/**
 * Process Frequently Bought Together Chat GPT Creation
 */
function wc_update_purchase_data_custom_table($order_id) {
    global $wpdb;
    
    // Get the order
    $order = wc_get_order($order_id);

    // Check the order status
    $order_status = $order->get_status();

    // Define which order statuses we want to process
    $valid_statuses = array('completed', 'cancelled', 'refunded', 'failed');

    if (!in_array($order_status, $valid_statuses)) {
        return; // Skip if the order status isn't one we want to process
    }
    
    // Check if the order was already processed
    $is_processed = get_post_meta($order_id, 'related_product_search_complete', true);
    
    if ($is_processed) {
        return; // Skip the order if it's already been processed
    }
    
    $items = $order->get_items();

    // Mark single-item orders as processed and then skip them
    if (count($items) <= 1) {
        update_post_meta($order_id, 'related_product_search_complete', 1);
        return;
    }

    foreach ($items as $item) {
        $current_product_id = $item->get_product_id();

        // Validate the product ID
        if (!$current_product_id) {
            continue; // Skip the current iteration if product ID is not valid
        }

        foreach ($items as $inner_item) {
            $related_product_id = $inner_item->get_product_id();

            // Check and skip if the products are the same or if the related product ID is not valid
            if ($current_product_id == $related_product_id || !$related_product_id) {
                continue;
            }

            $table_name = $wpdb->prefix . "customers_also_bought";
            
            $existing_entry = $wpdb->get_var($wpdb->prepare(
                "SELECT times_purchased FROM $table_name WHERE product_id = %d AND also_bought_product_id = %d",
                $current_product_id, $related_product_id
            ));
            
            if ($existing_entry) {
                $wpdb->query($wpdb->prepare(
                    "UPDATE $table_name SET times_purchased = times_purchased + 1 WHERE product_id = %d AND also_bought_product_id = %d",
                    $current_product_id, $related_product_id
                ));
            } else {
                $wpdb->insert($table_name, [
                    'product_id' => $current_product_id,
                    'also_bought_product_id' => $related_product_id,
                    'times_purchased' => 1
                ]);
            }
        }
    }

    // Mark the order as processed for related products
    update_post_meta($order_id, 'related_product_search_complete', 1);
}
