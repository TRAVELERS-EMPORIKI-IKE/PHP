<?php

/**
 * Add Status Awaiting Shipment and Shipped
 */
// Add custom statuses to order statuses
function add_custom_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;

        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-awaiting-shipment'] = 'Awaiting Shipment';
            $new_order_statuses['wc-shipped'] = 'Shipped';
        }
    }

    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'add_custom_order_statuses' );

// Register new order statuses
function register_custom_order_statuses() {
    register_post_status( 'wc-awaiting-shipment', array(
        'label'                     => 'Awaiting Shipment',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Awaiting Shipment <span class="count">(%s)</span>', 'Awaiting Shipment <span class="count">(%s)</span>' )
    ) );

    register_post_status( 'wc-shipped', array(
        'label'                     => 'Shipped',
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'register_custom_order_statuses' );

// Add custom statuses to bulk edit
function add_custom_order_statuses_bulk_edit( $bulk_actions ) {
    $bulk_actions['mark_awaiting-shipment'] = 'Change status to Awaiting Shipment';
    $bulk_actions['mark_shipped'] = 'Change status to Shipped';
    return $bulk_actions;
}
add_filter( 'bulk_actions-edit-shop_order', 'add_custom_order_statuses_bulk_edit', 20, 1 );
