<?php

/**
 * Send Bacs Instruction Email.
 */
add_action('woocommerce_new_order', 'send_bacs_payment_email', 10, 1);
function send_bacs_payment_email($order_id) {
    $order = wc_get_order($order_id);
	$order_total = $order->get_total();
    // Check if the payment method is BACS
    if ($order->get_payment_method() !== 'bacs') {
        return;
    }

    // Get the order language
    $lang = get_post_meta($order_id, 'lang', true);
    
    // Bank Details
    $company_name = 'TRAVELERS EMPORIKI IKE';
    $account_number = 'GR24 0172 1450 0051 4509 2301 393';
    $sort_code = 'PIRBGRAA';
    
    // Set the email subject and message based on the order language
    switch($lang) {
		case 'bg':
             $subject = 'Инструкции за плащане на BACS за поръчка #' . $order->get_id();
             $message = 'Уважаеми' . $order->get_billing_first_name() . ",

Благодаря ви за вашата поръчка. Моля, следвайте инструкциите по-долу, за да завършите плащането си чрез BACS:

1. Влезте в акаунта си за онлайн банкиране.
2. Направете плащане по следната банкова сметка:

Име на фирмата: $company_name
Номер на сметката: $account_number
Код на сортиране: $sort_code

Моля, включете номера на вашата поръчка в раздела за справка.

След като получим вашето плащане, ние ще обработим вашата поръчка и ще ви изпратим имейл за потвърждение на доставката.

Благодаря ви за вашата поръчка.";
            break;
		case 'hr':
             $subject = 'BACS upute za plaćanje za narudžbu #' . $order->get_id();
             $message = 'Dragi' . $order->get_billing_first_name() . ",

Hvala na Vašoj Narudžbi. Slijedite upute u nastavku kako biste dovršili plaćanje koristeći BACS:

1. Prijavite se na svoj račun za internet bankarstvo.
2. Izvršite uplatu na sljedeći bankovni račun:

Naziv tvrtke: $company_name
Broj računa: $account_number
Šifra sortiranja: $sort_code

Uključite svoj broj narudžbe u odjeljak s referencama.

Nakon što primimo vašu uplatu, obradit ćemo vašu narudžbu i poslati vam e-poruku s potvrdom dostave.

Hvala na Vašoj Narudžbi.";
            break;
		case 'cs':
             $subject = 'Pokyny k platbě BACS pro objednávku #' . $order->get_id();
             $message = 'Vážený ' . $order->get_billing_first_name() . ",

Děkujeme za Vaši objednávku. Pro dokončení platby pomocí BACS postupujte podle následujících pokynů:

1. Přihlaste se ke svému účtu online bankovnictví.
2. Proveďte platbu na následující bankovní účet:

Název společnosti: $company_name
Číslo účtu: $account_number
Třídicí kód: $sort_code

Do sekce reference uveďte číslo vaší objednávky.

Jakmile obdržíme vaši platbu, zpracujeme vaši objednávku a zašleme vám e-mail s potvrzením odeslání.

Děkujeme za Vaši objednávku.";
            break;
		case 'nl':
             $subject = 'BACS-betaalinstructies voor bestelling #' . $order->get_id();
             $message = 'Beste' . $order->get_billing_first_name() . ",

Bedankt voor je bestelling. Volg de onderstaande instructies om uw betaling met BACS te voltooien:

1. Log in op uw online bankrekening.
2. Maak een betaling over naar de volgende bankrekening:

Bedrijfsnaam: $company_name
Rekeningnummer: $account_number
Sorteercode: $sort_code

Vermeld uw bestelnummer in het referentiegedeelte.

Zodra wij uw betaling hebben ontvangen, verwerken wij uw bestelling en sturen wij u een verzendbevestiging per e-mail.

Bedankt voor je bestelling.";
            break;
		case 'nl':
             $subject = 'BACS-betaalinstructies voor bestelling #' . $order->get_id();
             $message = 'Beste' . $order->get_billing_first_name() . ",

Bedankt voor je bestelling" . wc_price($order_total) . ". Volg de onderstaande instructies om uw betaling met BACS te voltooien:

1. Log in op uw online bankrekening.
2. Maak een betaling over naar de volgende bankrekening:

Bedrijfsnaam: $company_name
Rekeningnummer: $account_number
Sorteercode: $sort_code

Vermeld uw bestelnummer in het referentiegedeelte.

Zodra wij uw betaling hebben ontvangen, verwerken wij uw bestelling en sturen wij u een verzendbevestiging per e-mail.

Bedankt voor je bestelling.";
            break;
        case 'el':
            $subject = 'Οδηγίες πληρωμής BACS για την παραγγελία #' . $order->get_id();
            $message = 'Αγαπητέ ' . $order->get_billing_first_name() . ",
            
Ευχαριστούμε για την παραγγελία σας. Παρακαλούμε ακολουθήστε τις παρακάτω οδηγίες για να ολοκληρώσετε την πληρωμή σας μέσω BACS:

1. Συνδεθείτε στο διαδικτυακό σας τραπεζικό λογαριασμό.
2. Κάντε μια πληρωμή στον παρακάτω τραπεζικό λογαριασμό:

Όνομα Εταιρείας: $company_name
Αριθμός Λογαριασμού: $account_number
Κωδικός: $sort_code

Παρακαλούμε συμπεριλάβετε τον αριθμό της παραγγελίας σας στο τμήμα αναφοράς.

Μόλις λάβουμε την πληρωμή σας, θα επεξεργαστούμε την παραγγελία σας και θα σας στείλουμε ένα email επιβεβαίωσης αποστολής.

Ευχαριστούμε για την παραγγελία σας.";
		break;
		case 'en':
             $subject = 'BACS payment instructions for order #' . $order->get_id();
            $message = 'Dear ' . $order->get_billing_first_name() . ",

Thank you for your order. Please follow the instructions below to complete your payment using BACS:

1. Log in to your online banking account.
2. Make a payment to the following bank account:

Company Name: $company_name
Account Number: $account_number
Sort Code: $sort_code

Please include your order number in the reference section.

Once we have received your payment, we will process your order and send you a shipping confirmation email.

Thank you for your business.";
            break;
        // Add more cases for other languages here
        default:
            // Default to English if the order language is not supported
            $subject = 'BACS payment instructions for order #' . $order->get_id();
            $message = 'Dear ' . $order->get_billing_first_name() . ",

Thank you for your order. Please follow the instructions below to complete your payment using BACS:

1. Log in to your online banking account.
2. Make a payment to the following bank account:

Company Name: $company_name
Account Number: $account_number
Sort Code: $sort_code

Please include your order number in the reference section.

Once we have received your payment, we will process your order and send you a shipping confirmation email.

Thank you for your business.";
    }

    // Send the email
    wc_mail($order->get_billing_email(), $subject, $message);
}
