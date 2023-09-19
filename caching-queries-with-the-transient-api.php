<?php

/**
 * Caching Queries with the Transient API chatgpt enhanced 
 */
// Get any existing copy of our transient data
if ( false === ( $special_query_results = get_transient( 'special_query_results' ) ) ) {
    // It wasn't there, so regenerate the data and save the transient
    $args = array(
        'cat'            => 5,
        'orderby'        => 'rand',
        'tag'            => 'tech',
        'meta_query'     => array(
            array(
                'key' => '_thumbnail_id',
            ),
        )
    );

    $special_query_results = new WP_Query( $args );

    // Save the transient with an expiration time of 1 hour (3600 seconds)
    set_transient( 'special_query_results', $special_query_results, 3600 );
}

// Use the data like you would have normally...
