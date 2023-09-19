<?php

/**
 * Display Product Bought Together Chat GPT Created
 */
// Hook into WooCommerce Single Product Page after product summary.
add_action('woocommerce_after_single_product_summary', 'show_related_products_based_on_purchase', 20);

function show_related_products_based_on_purchase() {
    global $product, $wpdb;

    $current_product_id = $product->get_id();

    $table_name = $wpdb->prefix . "customers_also_bought";

    $related_products = $wpdb->get_results($wpdb->prepare(
        "SELECT also_bought_product_id FROM $table_name WHERE product_id = %d ORDER BY times_purchased DESC LIMIT 20",
        $current_product_id
    ));

    if (!$related_products) {
        return;
    }

    echo '<div class="related-products-based-on-purchase">';
    echo '<h2>' . esc_html__('Customers who bought this also bought:', 'oceanwp') . '</h2>';

    $counter = 0;

    foreach ($related_products as $related_product) {
        $_product = wc_get_product($related_product->also_bought_product_id);

        if (!$_product || !$_product->is_visible()) {
            continue;
        }

        if ($counter % 5 == 0) {
            if ($counter > 0) {
                echo '</ul>';
            }
            echo '<ul class="products-related" style="display: flex; justify-content: space-between; margin-bottom: 20px;">';
        }

        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($_product->get_id()), 'woocommerce_thumbnail');

        echo '<li class="product" style="flex: 1; margin: 0 5px; text-align: center;">';
        echo '<a href="' . esc_url(get_permalink($_product->get_id())) . '">';
        if ($product_image) {
            echo '<img src="' . esc_url($product_image[0]) . '" alt="' . esc_attr($_product->get_name()) . '">';
        }
        echo '<h2 class="woocommerce-loop-product__title">' . get_the_title($_product->get_id()) . '</h2>';
        echo '</a>';
        echo '<span class="price">' . $_product->get_price_html() . '</span>';

        // Check product type and show appropriate button
        if ($_product->get_type() == 'simple') {
            echo '<a href="?add-to-cart=' . $_product->get_id() . '" class="button add_to_cart_button">' . esc_html__('Add to cart', 'oceanwp') . '</a>';
        } elseif ($_product->get_type() == 'variable') {
            echo '<a href="' . esc_url(get_permalink($_product->get_id())) . '" class="button">' . esc_html__('Select options', 'oceanwp') . '</a>';
        }

        echo '</li>';

        $counter++;

        if ($counter % 5 == 0 || $counter == count($related_products)) {
            echo '</ul>';
        }
    }

    echo '</div>';
}
