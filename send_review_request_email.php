add_action('woocommerce_order_status_completed', 'send_review_request_email', 10, 1);

function send_review_request_email($order_id) {
    if (!$order_id) {
        return;
    }

    $order = wc_get_order($order_id);
    $email_to = $order->get_billing_email();
    $customer_name = $order->get_billing_first_name();
    $shop_name = get_bloginfo('name');
    $subject = "Thank You for Your Purchase - We'd Love to Hear Your Thoughts!";
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    // Get the order language
    $lang = get_post_meta($order_id, 'lang', true);

    // Initialize email content
    $email_content = "";

    switch ($lang) {
        case 'en':
            $email_content = "<html><body><h1>Dear {$customer_name},</h1><p>We hope you're enjoying your recent purchase from {$shop_name}. Your satisfaction is our top priority, and we'd love to hear how we did.</p><p>Would you mind taking a moment to leave us a review on Google? <a href='https://g.page/r/CbLYq9N528ueEBM/review'>Leave Your Review</a></p>
        <p>As a token of our appreciation, every review will enter you into a monthly draw to win a 5€ euro coupon for later purchases from us.</p>
        <p>Best Regards,<br>
        The {$shop_name} Team</p><!-- English content here --></body></html>";
            break;

        case 'el':
            $email_content = "<html><body><h1>Αγαπητέ {$customer_name},</h1><p>Ελπίζουμε να απολαμβάνετε την πρόσφατη αγορά σας από {$shop_name}.</p><!-- Greek content here --></body></html>";
            break;

        // Add more cases for additional languages
        default:
        $email_content = "<html><body><h1>Dear {$customer_name},</h1><p>We hope you're enjoying your recent purchase from {$shop_name}. Your satisfaction is our top priority, and we'd love to hear how we did.</p><p>Would you mind taking a moment to leave us a review on Google? <a href='https://g.page/r/CbLYq9N528ueEBM/review'>Leave Your Review</a></p>
        <p>As a token of our appreciation, every review will enter you into a monthly draw to win a 5€ euro coupon for later purchases from us.</p>
        <p>Best Regards,<br>
        The {$shop_name} Team</p><!-- Default English content here --></body></html>";
            break;
    }

    wp_mail($email_to, $subject, $email_content, $headers);
}
