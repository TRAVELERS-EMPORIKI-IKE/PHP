<?php

/**
 * build initial also bought data Button in WP-Admin Chat GPT Created
 */
function wc_build_initial_also_bought_data() {
    ini_set('max_execution_time', 0);  // Unlimited execution time
    //ini_set('memory_limit','256M');    // Increase memory limit

    // Define the order statuses you want to process
    $statuses_to_process = array('wc-completed', 'wc-cancelled', 'wc-refunded', 'wc-failed');

    // Get all orders with the defined statuses
    $args = array(
        'post_type'      => 'shop_order',
        'posts_per_page' => -1,
        'post_status'    => $statuses_to_process,
        'fields'         => 'ids',
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => 'related_product_search_complete',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'key'     => 'related_product_search_complete',
                'value'   => '0',
                'compare' => '='
            )
        )
    );
    
    $query = new WP_Query($args);
    $orders = $query->posts;
    
    foreach ($orders as $order_id) {
        wc_update_purchase_data_custom_table($order_id);
    }
    
    echo "Processed " . count($orders) . " orders.";
}

// Create a simple admin page to trigger the function
add_action('admin_menu', function() {
    add_menu_page('Process Orders', 'Process Orders', 'manage_options', 'wc_process_orders', 'wc_build_initial_also_bought_data');
});
