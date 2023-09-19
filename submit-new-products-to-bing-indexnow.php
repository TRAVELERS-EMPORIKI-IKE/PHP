<?php

/**
 * Submit New Products to Bing IndexNow
 */
function submit_url_to_bing( $post_id ) {
    // If this is just a revision, don't send the URL.
    if ( wp_is_post_revision( $post_id ) ) return;

    // Get the post object
    $post = get_post( $post_id );

    // Check if it's a product, post, or page
    if ( $post->post_type == 'product' || $post->post_type == 'post' || $post->post_type == 'page' ) {
        // Get the URL of the new post/product/page
        $url = get_permalink( $post_id );

        // Define the endpoint and payload
        $endpoint = 'https://www.bing.com/IndexNow';
        $payload  = array(
            'host'       => 'vapetravellers.eu', // Replace with your domain
            'key'        => 'c1588c5159af4c8c9fde8c751b54097b', // Replace with your key
            'keyLocation'=> 'https://vapetravellers.eu/c1588c5159af4c8c9fde8c751b54097b.txt', // Replace with your key location
            'urlList'    => array( $url )
        );

        // Send the POST request
        $response = wp_safe_remote_post( $endpoint, array(
            'headers' => array( 'Content-Type' => 'application/json; charset=utf-8' ),
            'body'    => json_encode( $payload ),
        ));

        // Log the response to the custom table
        global $wpdb;
        $table_name = $wpdb->prefix . '01_Bing_Webmaster_SubmitURL_Results'; // Specify the table name with prefix
        $result = print_r($response, true);
        $wpdb->insert(
            $table_name,
            array(
                'Result_Date' => current_time('Y-m-d'), // Date in 'Y-m-d' format
                'Result'      => $result,
            ),
            array(
                '%s', // Result_Date as date
                '%s', // Result as string
            )
        );

        // If there's an error with the insertion, you can log it for debugging
        if ($wpdb->last_error) {
            error_log($wpdb->last_error);
        }
    }
}

add_action( 'publish_product', 'submit_url_to_bing' ); // For WooCommerce products
add_action( 'publish_post', 'submit_url_to_bing' );    // For posts
add_action( 'publish_page', 'submit_url_to_bing' );    // For pages
