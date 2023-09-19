<?php

/**
 * Populate Litespeed Crawler DB by chatgpt
 */
// Register the custom admin menu
add_action('admin_menu', 'register_my_custom_menu_page');

function register_my_custom_menu_page() {
    add_menu_page('Populate Litespeed Crawler DB', 'Populate Litespeed Crawler DB', 'manage_options', 'populate_litespeed_crawler', 'populate_litespeed_crawler_function', '', 99);
}

// Function that performs the actual operations
function populate_litespeed_crawler_function() {

    global $wpdb;
    $table_name = "hvjts_litespeed_crawler";

    $sitemaps = [
        'https://vapetravellers.eu/post-sitemap.xml',
'https://vapetravellers.eu/page-sitemap.xml',
'https://vapetravellers.eu/page-sitemap2.xml',
'https://vapetravellers.eu/page-sitemap3.xml',
'https://vapetravellers.eu/page-sitemap4.xml',
'https://vapetravellers.eu/page-sitemap5.xml',
'https://vapetravellers.eu/page-sitemap6.xml',
'https://vapetravellers.eu/page-sitemap7.xml',
'https://vapetravellers.eu/page-sitemap8.xml',
'https://vapetravellers.eu/page-sitemap9.xml',
'https://vapetravellers.eu/page-sitemap10.xml',
'https://vapetravellers.eu/page-sitemap11.xml',
'https://vapetravellers.eu/page-sitemap12.xml',
'https://vapetravellers.eu/page-sitemap13.xml',
'https://vapetravellers.eu/page-sitemap14.xml',
'https://vapetravellers.eu/page-sitemap15.xml',
'https://vapetravellers.eu/page-sitemap16.xml',
'https://vapetravellers.eu/page-sitemap17.xml',
'https://vapetravellers.eu/page-sitemap18.xml',
'https://vapetravellers.eu/page-sitemap19.xml',
'https://vapetravellers.eu/page-sitemap20.xml',
'https://vapetravellers.eu/page-sitemap21.xml',
'https://vapetravellers.eu/page-sitemap22.xml',
'https://vapetravellers.eu/page-sitemap23.xml',
'https://vapetravellers.eu/page-sitemap24.xml',
'https://vapetravellers.eu/page-sitemap25.xml',
'https://vapetravellers.eu/page-sitemap26.xml',
'https://vapetravellers.eu/page-sitemap27.xml',
'https://vapetravellers.eu/page-sitemap28.xml',
'https://vapetravellers.eu/page-sitemap29.xml',
'https://vapetravellers.eu/page-sitemap30.xml',
'https://vapetravellers.eu/page-sitemap31.xml',
'https://vapetravellers.eu/page-sitemap32.xml',
'https://vapetravellers.eu/page-sitemap33.xml',
'https://vapetravellers.eu/page-sitemap34.xml',
'https://vapetravellers.eu/page-sitemap35.xml',
'https://vapetravellers.eu/page-sitemap36.xml',
'https://vapetravellers.eu/page-sitemap37.xml',
'https://vapetravellers.eu/page-sitemap38.xml',
'https://vapetravellers.eu/page-sitemap39.xml',
'https://vapetravellers.eu/page-sitemap40.xml',
'https://vapetravellers.eu/page-sitemap41.xml',
'https://vapetravellers.eu/page-sitemap42.xml',
'https://vapetravellers.eu/page-sitemap43.xml',
'https://vapetravellers.eu/page-sitemap44.xml',
'https://vapetravellers.eu/page-sitemap45.xml',
'https://vapetravellers.eu/page-sitemap46.xml',
'https://vapetravellers.eu/page-sitemap47.xml',
'https://vapetravellers.eu/page-sitemap48.xml',
'https://vapetravellers.eu/page-sitemap49.xml',
'https://vapetravellers.eu/page-sitemap50.xml',
'https://vapetravellers.eu/page-sitemap51.xml',
'https://vapetravellers.eu/page-sitemap52.xml',
'https://vapetravellers.eu/page-sitemap53.xml',
'https://vapetravellers.eu/page-sitemap54.xml',
'https://vapetravellers.eu/page-sitemap55.xml',
'https://vapetravellers.eu/page-sitemap56.xml',
'https://vapetravellers.eu/page-sitemap57.xml',
'https://vapetravellers.eu/page-sitemap58.xml',
'https://vapetravellers.eu/page-sitemap59.xml',
'https://vapetravellers.eu/page-sitemap60.xml',
'https://vapetravellers.eu/page-sitemap61.xml',
'https://vapetravellers.eu/page-sitemap62.xml',
'https://vapetravellers.eu/page-sitemap63.xml',
'https://vapetravellers.eu/product-sitemap.xml',
'https://vapetravellers.eu/product-sitemap2.xml',
'https://vapetravellers.eu/product-sitemap3.xml',
'https://vapetravellers.eu/product-sitemap4.xml',
'https://vapetravellers.eu/product-sitemap5.xml',
'https://vapetravellers.eu/product-sitemap6.xml',
'https://vapetravellers.eu/product-sitemap7.xml',
'https://vapetravellers.eu/product-sitemap8.xml',
'https://vapetravellers.eu/product-sitemap9.xml',
'https://vapetravellers.eu/product-sitemap10.xml',
'https://vapetravellers.eu/product-sitemap11.xml',
'https://vapetravellers.eu/product-sitemap12.xml',
'https://vapetravellers.eu/product-sitemap13.xml',
'https://vapetravellers.eu/product-sitemap14.xml',
'https://vapetravellers.eu/product-sitemap15.xml',
'https://vapetravellers.eu/product-sitemap16.xml',
'https://vapetravellers.eu/product-sitemap17.xml',
'https://vapetravellers.eu/product-sitemap18.xml',
'https://vapetravellers.eu/product-sitemap19.xml',
'https://vapetravellers.eu/product-sitemap20.xml',
'https://vapetravellers.eu/product-sitemap21.xml',
'https://vapetravellers.eu/product-sitemap22.xml',
'https://vapetravellers.eu/product-sitemap23.xml',
'https://vapetravellers.eu/product-sitemap24.xml',
'https://vapetravellers.eu/product-sitemap25.xml',
'https://vapetravellers.eu/product-sitemap26.xml',
'https://vapetravellers.eu/product-sitemap27.xml',
'https://vapetravellers.eu/product-sitemap28.xml',
'https://vapetravellers.eu/product-sitemap29.xml',
'https://vapetravellers.eu/product-sitemap30.xml',
'https://vapetravellers.eu/product-sitemap31.xml',
'https://vapetravellers.eu/product-sitemap32.xml',
'https://vapetravellers.eu/product-sitemap33.xml',
'https://vapetravellers.eu/product-sitemap34.xml',
'https://vapetravellers.eu/product-sitemap35.xml',
'https://vapetravellers.eu/category-sitemap.xml',
'https://vapetravellers.eu/post_tag-sitemap.xml',
'https://vapetravellers.eu/product_cat-sitemap.xml',
'https://vapetravellers.eu/product_cat-sitemap2.xml',
'https://vapetravellers.eu/product_cat-sitemap3.xml',
'https://vapetravellers.eu/product_cat-sitemap4.xml',
'https://vapetravellers.eu/product_cat-sitemap5.xml',
'https://vapetravellers.eu/product_tag-sitemap.xml',
'https://vapetravellers.eu/product_tag-sitemap2.xml',
'https://vapetravellers.eu/product_tag-sitemap3.xml',
'https://vapetravellers.eu/product_tag-sitemap4.xml',
'https://vapetravellers.eu/product_tag-sitemap5.xml',
'https://vapetravellers.eu/product_tag-sitemap6.xml',
'https://vapetravellers.eu/product_tag-sitemap7.xml',
'https://vapetravellers.eu/product_tag-sitemap8.xml',
'https://vapetravellers.eu/product_tag-sitemap9.xml',
'https://vapetravellers.eu/product_tag-sitemap10.xml',
'https://vapetravellers.eu/product_tag-sitemap11.xml',
'https://vapetravellers.eu/product_tag-sitemap12.xml',
'https://vapetravellers.eu/product_tag-sitemap13.xml',
'https://vapetravellers.eu/product_tag-sitemap14.xml',
'https://vapetravellers.eu/product_tag-sitemap15.xml',
'https://vapetravellers.eu/product_tag-sitemap16.xml',
'https://vapetravellers.eu/product_tag-sitemap17.xml',
'https://vapetravellers.eu/product_tag-sitemap18.xml',
'https://vapetravellers.eu/product_tag-sitemap19.xml',
'https://vapetravellers.eu/product_tag-sitemap20.xml',
'https://vapetravellers.eu/product_tag-sitemap21.xml',
'https://vapetravellers.eu/product_tag-sitemap22.xml',
'https://vapetravellers.eu/product_tag-sitemap23.xml',
'https://vapetravellers.eu/product_tag-sitemap24.xml',
'https://vapetravellers.eu/product_tag-sitemap25.xml',
'https://vapetravellers.eu/product_tag-sitemap26.xml',
'https://vapetravellers.eu/product_tag-sitemap27.xml',
'https://vapetravellers.eu/product_tag-sitemap28.xml',
'https://vapetravellers.eu/product_tag-sitemap29.xml',
'https://vapetravellers.eu/product_tag-sitemap30.xml',
'https://vapetravellers.eu/product_tag-sitemap31.xml',
'https://vapetravellers.eu/product_tag-sitemap32.xml',
'https://vapetravellers.eu/product_tag-sitemap33.xml',
'https://vapetravellers.eu/product_tag-sitemap34.xml',
'https://vapetravellers.eu/product_tag-sitemap35.xml',
'https://vapetravellers.eu/product_tag-sitemap36.xml'
    ];

    foreach ($sitemaps as $sitemap) {
        $xml = simplexml_load_file($sitemap);
        
        if (!$xml) {
            echo "Failed to load sitemap: $sitemap<br>";
            continue;
        }
        
        foreach ($xml->url as $urlElement) {
            $url = str_replace('https://vapetravellers.eu', '', $urlElement->loc);

            $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE url = %s", $url));
            
            if ($exists === 0) {
                $data = [
                    'url'    => $url,
                    'res'    => '----------------',
                    'reason' => ',,,,,,,,,,,,,,,,',
                ];

                $wpdb->insert($table_name, $data);
                echo "Inserted: $url<br>";
            } else {
                echo "Already exists: $url<br>";
            }
        }
    }
}
