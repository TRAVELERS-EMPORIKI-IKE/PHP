<?php

/**
 * Add Product SKU
 */
// Hook into the 'save_post' action to generate SKU on product creation
add_action('save_post', 'generate_product_sku', 10, 2);

function generate_product_sku($post_id, $post) {
    // Check if the post is a product or product variation and is being newly created
    if (($post->post_type === 'product' || $post->post_type === 'product_variation') && wp_is_post_revision($post_id) === false) {
        $product_id = $post_id; // You can use other logic to get a unique ID if needed
        $sku_prefix = 'SKU'; // Customize your SKU prefix here
        
        // Generate SKU by combining prefix and product ID
        $sku = $sku_prefix . '-' . $product_id;
        
        // Update the product SKU
        update_post_meta($post_id, '_sku', $sku);
    }
}
