<?php

/**
 * Cros-sells Upsells from ChatGPT
 */
// Function to update upsells and cross-sells for a specific product
function update_upsell_crosssell_for_product( $product_id ) {
    // Check existing upsell and cross-sell records
    $existing_crosssell_ids = get_post_meta( $product_id, '_crosssell_ids', true );
    $existing_upsell_ids = get_post_meta( $product_id, '_upsell_ids', true );
    if ( $existing_crosssell_ids !== 'a:0:{}' || $existing_upsell_ids !== 'a:0:{}' ) return;

    // Get the product object
    $product = wc_get_product( $product_id );
    if ( ! $product ) return;

    // Get primary category of the product
    $categories = $product->get_category_ids();
    if ( empty( $categories ) ) return;
    $primary_category = $categories[0];

    // Get all products in the same primary category
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post__not_in'   => array( $product_id ), // Exclude the current product
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $primary_category,
            ),
        ),
    );
    $products_in_same_category = get_posts( $args );
    $product_ids = array();
    foreach ( $products_in_same_category as $related_product ) {
        $product_ids[] = $related_product->ID;
    }

    // Update or create the _crosssell_ids and _upsell_ids
    if ( ! empty( $product_ids ) ) {
        update_post_meta( $product_id, '_crosssell_ids', $product_ids );
        update_post_meta( $product_id, '_upsell_ids', $product_ids );
    }
}

// Function to crawl all products and update upsells and cross-sells
function crawl_all_products_and_update() {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
    );
    $all_products = get_posts( $args );
    foreach ( $all_products as $product ) {
        update_upsell_crosssell_for_product( $product->ID );
    }
}

// Function to setup your custom functionality
function setup_custom_woocommerce_functionality() {
    // Run when a new product is created
    add_action( 'save_post_product', 'update_upsell_crosssell_for_product' );

    // Check if URL parameter is present
    if ( isset( $_GET['crawl_products'] ) && $_GET['crawl_products'] == '1' ) {
        crawl_all_products_and_update();
    }
}

// Hook into 'woocommerce_loaded' to ensure WooCommerce is fully loaded
add_action( 'woocommerce_loaded', 'setup_custom_woocommerce_functionality' );
