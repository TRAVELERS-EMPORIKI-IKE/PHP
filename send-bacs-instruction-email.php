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
	case 'el':
        $subject = 'Οδηγίες πληρωμής BACS για παραγγελία #' . $order->get_id();
        $message = '<strong>Αγαπητέ ' . $order->get_billing_first_name() . ',</strong><br><br>';
        $message .= 'Σας ευχαριστούμε για την παραγγελία σας συνολικού ποσού ' . wc_price($order_total) . '.<br>';
        $message .= 'Ακολουθήστε τις παρακάτω οδηγίες για να ολοκληρώσετε την πληρωμή σας χρησιμοποιώντας το BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Συνδεθείτε στο λογαριασμό σας στην τραπεζική σας τράπεζα.</li>';
        $message .= '<li>Κάντε μια πληρωμή στον ακόλουθο τραπεζικό λογαριασμό:</li>';
        $message .= '</ol>';
        $message .= '<strong>Όνομα εταιρείας:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Αριθμός λογαριασμού:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Κωδικός ταξινόμησης:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Παρακαλούμε συμπεριλάβετε τον αριθμό παραγγελίας σας στην ενότητα αναφοράς.<br>';
        $message .= 'Μόλις λάβουμε την πληρωμή σας, θα επεξεργαστούμε την παραγγελία σας και θα σας στείλουμε ένα email επιβεβαίωσης αποστολής.<br><br>';
        $message .= '<strong>****ΠΑΡΑΚΑΛΩ ΣΗΜΕΙΩΣΤΕ ΟΤΙ Η ΠΛΗΡΩΜΗ ΠΡΕΠΕΙ ΝΑ ΕΜΦΑΝΙΣΤΕΙ ΣΤΟΝ ΛΟΓΑΡΙΑΣΜΟ ΤΗΣ ΕΤΑΙΡΕΙΑΣ ΜΑΣ ΜΕ ΤΟ ΑΚΡΙΒΕΣ ΠΟΣΟ ΤΗΣ ΠΑΡΑΓΓΕΛΙΑΣ ΣΑΣ, ΟΠΟΙΕΣ ΤΡΑΠΕΖΙΚΕΣ ΧΡΕΩΣΕΙΣ ΠΡΕΠΕΙ ΝΑ ΚΑΛΥΦΘΟΥΝ ΑΠΟ ΕΣΑΣ****</strong>';
    break;
    case 'de':
        $subject = 'BACS-Zahlungsanweisungen für Bestellung #' . $order->get_id();
        $message = 'Sehr geehrte ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Vielen Dank für Ihre Bestellung in Höhe von ' . wc_price($order_total) . '. Bitte befolgen Sie die folgenden Anweisungen, um Ihre Zahlung mit BACS abzuschließen:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Melden Sie sich bei Ihrem Online-Banking-Konto an.</li>';
        $message .= '<li>Tätigen Sie eine Zahlung auf das folgende Bankkonto:</li>';
        $message .= '</ol>';
        $message .= '<strong>Firmenname:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Kontonummer:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sort Code:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Bitte geben Sie Ihre Bestellnummer im Referenzbereich an.<br>';
        $message .= 'Sobald wir Ihre Zahlung erhalten haben, werden wir Ihre Bestellung bearbeiten und Ihnen eine Versandbestätigungs-E-Mail senden.<br><br>';
        $message .= '<strong>****BITTE BEACHTEN SIE, DASS DIE ZAHLUNG AUF UNSEREM FIRMENKONTO MIT DEM EXAKTEN BETRAG IHRER BESTELLUNG ERSCHIENEN SEIN MUSS, ALLE BANKGEBÜHREN MÜSSEN VON IHNEN ABGEDECKT WERDEN****</strong>';
    break;
    case 'fr':
        $subject = 'Instructions de paiement BACS pour la commande #' . $order->get_id();
        $message = 'Cher ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Merci pour votre commande d\'un montant total de ' . wc_price($order_total) . '. Veuillez suivre les instructions ci-dessous pour effectuer votre paiement en utilisant BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Connectez-vous à votre compte bancaire en ligne.</li>';
        $message .= '<li>Effectuez un paiement sur le compte bancaire suivant:</li>';
        $message .= '</ol>';
        $message .= '<strong>Nom de la société:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Numéro de compte:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Code de tri:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Veuillez inclure votre numéro de commande dans la section référence.<br>';
        $message .= 'Une fois que nous aurons reçu votre paiement, nous traiterons votre commande et vous enverrons un e-mail de confirmation d\'expédition.<br><br>';
        $message .= '<strong>****VEUILLEZ NOTER QUE LE PAIEMENT DOIT APPARAÎTRE SUR NOTRE COMPTE D\'ENTREPRISE AVEC LE MONTANT EXACT DE VOTRE COMMANDE, TOUTES LES FRAIS BANCAIRES DOIVENT ÊTRE COUVERTES PAR VOUS****</strong>';
    break;
    case 'it':
        $subject = 'Istruzioni per il pagamento BACS per l\'ordine #' . $order->get_id();
        $message = 'Gentile ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Grazie per il tuo ordine di un totale di ' . wc_price($order_total) . '. Seguire le istruzioni di seguito per completare il pagamento utilizzando BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Accedi al tuo account bancario online.</li>';
        $message .= '<li>Esegui un pagamento sul seguente conto bancario:</li>';
        $message .= '</ol>';
        $message .= '<strong>Nome azienda:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Numero di conto:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sort Code:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Includere il numero d\'ordine nella sezione riferimento.<br>';
        $message .= 'Una volta ricevuto il pagamento, elaboreremo il tuo ordine e ti invieremo una e-mail di conferma di spedizione.<br><br>';
        $message .= '<strong>****SI PREGA DI NOTARE CHE IL PAGAMENTO DEVE APPARIRE SUL NOSTRO CONTO AZIENDALE CON L\'IMPORTO ESATTO DEL TUO ORDINE, TUTTE LE SPESE BANCARIE DEVONO ESSERE COPIATE DA TE****</strong>';
    break;
    case 'es':
        $subject = 'Instrucciones de pago de BACS para el pedido #' . $order->get_id();
        $message = 'Estimado ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Gracias por su pedido por un total de ' . wc_price($order_total) . '. Siga las instrucciones a continuación para completar su pago utilizando BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Inicie sesión en su cuenta bancaria en línea.</li>';
        $message .= '<li>Haga un pago a la siguiente cuenta bancaria:</li>';
        $message .= '</ol>';
        $message .= '<strong>Nombre de la empresa:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Número de cuenta:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Código de clasificación:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Incluya su número de pedido en la sección de referencia.<br>';
        $message .= 'Una vez que hayamos recibido su pago, procesaremos su pedido y le enviaremos un correo electrónico de confirmación de envío.<br><br>';
        $message .= '<strong>****TENGA EN CUENTA QUE EL PAGO DEBE APARECER EN NUESTRA CUENTA DE EMPRESA CON LA CANTIDAD EXACTA DE SU PEDIDO, TODOS LOS CARGOS BANCARIOS DEBEN SER CUBIERTOS POR USTED****</strong>';
    break;
    case 'pt-pt':
        $subject = 'Instruções de pagamento BACS para o pedido #' . $order->get_id();
        $message = 'Caro ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Obrigado pelo seu pedido no valor de ' . wc_price($order_total) . '. Siga as instruções abaixo para concluir seu pagamento usando BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Entre na sua conta bancária online.</li>';
        $message .= '<li>Faça um pagamento na seguinte conta bancária:</li>';
        $message .= '</ol>';
        $message .= '<strong>Nome da empresa:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Número da conta:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Código de classificação:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Inclua o número do seu pedido na seção de referência.<br>';
        $message .= 'Assim que recebermos seu pagamento, processaremos seu pedido e enviaremos um e-mail de confirmação de envio.<br><br>';
        $message .= '<strong>****POR FAVOR, NOTE QUE O PAGAMENTO DEVE APARECER NA NOSSA CONTA EMPRESARIAL COM O VALOR EXATO DO SEU PEDIDO, TODAS AS TAXAS BANCÁRIAS DEVEM SER COBERTAS POR VOCÊ****</strong>';
    break;
    case 'pt':
        $subject = 'Instruções de pagamento BACS para o pedido #' . $order->get_id();
        $message = 'Caro ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Obrigado pelo seu pedido no valor de ' . wc_price($order_total) . '. Siga as instruções abaixo para concluir seu pagamento usando BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Entre na sua conta bancária online.</li>';
        $message .= '<li>Faça um pagamento na seguinte conta bancária:</li>';
        $message .= '</ol>';
        $message .= '<strong>Nome da empresa:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Número da conta:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Código de classificação:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Inclua o número do seu pedido na seção de referência.<br>';
        $message .= 'Assim que recebermos seu pagamento, processaremos seu pedido e enviaremos um e-mail de confirmação de envio.<br><br>';
        $message .= '<strong>****POR FAVOR, NOTE QUE O PAGAMENTO DEVE APARECER NA NOSSA CONTA EMPRESARIAL COM O VALOR EXATO DO SEU PEDIDO, TODAS AS TAXAS BANCÁRIAS DEVEM SER COBERTAS POR VOCÊ****</strong>';
    break;
    case 'en':
        $subject = 'BACS payment instructions for order #' . $order->get_id();
        $message = 'Dear ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Thank you for your order with a total of ' . wc_price($order_total) . '. Please follow the instructions below to complete your payment using BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Log in to your online banking account.</li>';
        $message .= '<li>Make a payment to the following bank account:</li>';
        $message .= '</ol>';
        $message .= '<strong>Company Name:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Account Number:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sort Code:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Please include your order number in the reference section.<br>';
        $message .= 'Once we have received your payment, we will process your order and send you a shipping confirmation email.<br><br>';
        $message .= '<strong>****PLEASE NOTE PAYMENT MUST APPEAR ON OUR COMPANY ACCOUNT WITH THE EXACT AMOUNT OF YOUR ORDER, ANY BANK CHARGES MUST BE COVERED BY YOU****</strong>';
    break;
    case 'et':
        $subject = 'BACS maksejuhised tellimuse #' . $order->get_id();
        $message = 'Kallis ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Täname teid tellimuse eest kogusummas ' . wc_price($order_total) . '. Järgige allpool toodud juhiseid BACS-i kasutades makse lõpuleviimiseks:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Logige sisse oma pangakonto.</li>';
        $message .= '<li>Tehke makse järgmisele pangakontole:</li>';
        $message .= '</ol>';
        $message .= '<strong>Ettevõtte nimi:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Kontonumber:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sorteerimiskood:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Palun sisestage tellimuse number viite jaotisse.<br>';
        $message .= 'Kui oleme teie makse kätte saanud, töötleme teie tellimuse ja saadame teile e-kirja saatmise kinnituse.<br><br>';
        $message .= '<strong>****PALUN MÄRKIGE, ET MAKSE PEAB ILMUMA MEIE ETTEVÕTTE KONTOLE TÄPSE SUMMAGA, MIS ON TEIE TELLIMUS, KÕIK PANGA TASUD PEAVAD OLEMA TEIE KATETUD****</strong>';
    break;
    case 'fi':
        $subject = 'BACS-maksuohjeet tilaukselle #' . $order->get_id();
        $message = 'Hyvä ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Kiitos tilauksestasi yhteensä ' . wc_price($order_total) . '. Noudata alla olevia ohjeita suorittaaksesi maksun BACS: n avulla:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Kirjaudu sisään verkkopankkitilillesi.</li>';
        $message .= '<li>Suorita maksu seuraavalle pankkitilille:</li>';
        $message .= '</ol>';
        $message .= '<strong>Yrityksen nimi:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Tilinumero:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Lajittelukoodi:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Sisällytä tilausnumerosi viiteosioon.<br>';
        $message .= 'Kun olemme vastaanottaneet maksun, käsittelemme tilauksesi ja lähetämme sinulle toimitusvahvistuksen sähköpostitse.<br><br>';
        $message .= '<strong>****HUOMAA, ETTÄ MAKSU ON NÄYTETTÄVÄ YRITYKSEMME TILILLÄ TARKALLA MÄÄRÄLLÄ TILAUKSESTASI, KAIKKI PANKKIMAKSUT ON KATETTAVA SINULLE****</strong>';
    break;
    case 'sv':
        $subject = 'BACS-betalningsinstruktioner för beställning #' . $order->get_id();
        $message = 'Kära ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Tack för din beställning till ett totalt belopp av ' . wc_price($order_total) . '. Följ instruktionerna nedan för att slutföra din betalning med BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Logga in på ditt onlinebankkonto.</li>';
        $message .= '<li>Gör en betalning till följande bankkonto:</li>';
        $message .= '</ol>';
        $message .= '<strong>Företagsnamn:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Kontonummer:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sorteringskod:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Ange ditt beställningsnummer i referensavsnittet.<br>';
        $message .= 'När vi har mottagit din betalning kommer vi att behandla din beställning och skicka dig ett e-postmeddelande med bekräftelse på leverans.<br><br>';
        $message .= '<strong>****OBS! BETALNINGEN MÅSTE VISAS PÅ VÅR FÖRETAGSKONTO MED EXAKT BELOPP AV DIN BESTÄLLNING, ALLA BANKKOSTNADER MÅSTE VARA TÄCKT AV DIG****</strong>';
    break;
    case 'bg':
        $subject = 'Инструкции за плащане с BACS за поръчка #' . $order->get_id();
        $message = 'Уважаеми ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Благодарим ви за поръчката ви на обща стойност ' . wc_price($order_total) . '. Моля, следвайте инструкциите по-долу, за да завършите плащането си с BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Влезте в онлайн банковата си сметка.</li>';
        $message .= '<li>Направете плащане на следната банкова сметка:</li>';
        $message .= '</ol>';
        $message .= '<strong>Име на компанията:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Номер на сметка:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Код за сортиране:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Моля, включете номера на вашата поръчка в раздела за справка.<br>';
        $message .= 'След като получим вашето плащане, ще обработим вашата поръчка и ще ви изпратим имейл за потвърждение на доставката.<br><br>';
        $message .= '<strong>****МОЛЯ, ЗАБЕЛЕЖЕТЕ, ЧЕ ПЛАЩАНЕТО ТРЯБВА ДА СЕ ПОЯВИ НА НАШАТА СМЕТКА С ТОЧНА СУМА НА ВАШАТА ПОРЪЧКА, ВСИЧКИ БАНКОВИ ТАКСИ ТРЯБВА ДА БЪДАТ ПОКРИТИ ОТ ВАС****</strong>';
    break;
    case 'ro':
        $subject = 'Instrucțiuni de plată BACS pentru comanda #' . $order->get_id();
        $message = 'Dragă ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Vă mulțumim pentru comanda dvs. în valoare totală de ' . wc_price($order_total) . '. Vă rugăm să urmați instrucțiunile de mai jos pentru a vă finaliza plata folosind BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Conectați-vă la contul dvs. bancar online.</li>';
        $message .= '<li>Faceți o plată în contul bancar următor:</li>';
        $message .= '</ol>';
        $message .= '<strong>Numele companiei:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Număr de cont:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Cod de sortare:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Vă rugăm să includeți numărul comenzii dvs. în secțiunea de referință.<br>';
        $message .= 'Odată ce am primit plata dvs., vom procesa comanda dvs. și vă vom trimite un e-mail de confirmare a expedierii.<br><br>';
        $message .= '<strong>****VĂ RUGĂM SĂ REȚINEȚI CĂ PLATA TREBUIE SĂ APARĂ PE CONTUL NOSTRU DE COMPANIE CU SUMA EXACTĂ A COMENZII DVS., ORICE TAXE BANCARE TREBUIE SĂ FIE ACOPERITE DE DVS.****</strong>';
    break;
    case 'hr':
        $subject = 'BACS upute za plaćanje za narudžbu #' . $order->get_id();
        $message = 'Dragi ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Hvala vam na narudžbi u iznosu od ' . wc_price($order_total) . '. Slijedite upute u nastavku kako biste dovršili svoju uplatu putem BACS-a:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Prijavite se na svoj online bankovni račun.</li>';
        $message .= '<li>Izvršite uplatu na sljedeći bankovni račun:</li>';
        $message .= '</ol>';
        $message .= '<strong>Naziv tvrtke:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Broj računa:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sort Code:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Uključite broj narudžbe u odjeljak za referencu.<br>';
        $message .= 'Nakon što primimo vašu uplatu, obradit ćemo vašu narudžbu i poslat ćemo vam e-poštu s potvrdom o otpremi.<br><br>';
        $message .= '<strong>****MOLIMO IMATI NA UMU DA SE PLAĆANJE MORA POJAVITI NA NAŠEM POSLOVNOM RAČUNU S TOČNIM IZNOSOM VAŠE NARUDŽBE, SVE BANKOVNE NAKNADE MORA BITI POKRIVENE OD STRANE VAS****</strong>';
    break;
    case 'sl':
        $subject = 'Navodila za plačilo BACS za naročilo #' . $order->get_id();
        $message = 'Spoštovani ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Hvala za vaše naročilo v skupnem znesku ' . wc_price($order_total) . '. Sledite spodnjim navodilom, da zaključite plačilo z BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Prijavite se v svoj spletni bančni račun.</li>';
        $message .= '<li>Izvedite plačilo na naslednji bančni račun:</li>';
        $message .= '</ol>';
        $message .= '<strong>Ime podjetja:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Številka računa:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Koda za sortiranje:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Vključite številko naročila v razdelek za sklice.<br>';
        $message .= 'Ko prejmemo vaše plačilo, bomo obdelali vaše naročilo in vam poslali e-poštno sporočilo o potrditvi pošiljanja.<br><br>';
        $message .= '<strong>****PROSIMO, UPOŠTEVAJTE, DA SE MORA PLAČILO POJAVITI NA NAŠEM POSLOVNEM RAČUNU Z NATANČNIM ZNESEKOM VAŠEGA NAROČILA, VSE BANČNE STROŠKE MORAJO BITI POKRITE OD VAS****</strong>';
    break;
    case 'cs':
        $subject = 'BACS platební pokyny pro objednávku #' . $order->get_id();
        $message = 'Vážený ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Děkujeme za vaši objednávku v celkové výši ' . wc_price($order_total) . '. Postupujte podle níže uvedených pokynů, abyste dokončili platbu pomocí BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Přihlaste se do svého účtu v internetovém bankovnictví.</li>';
        $message .= '<li>Proveďte platbu na následující bankovní účet:</li>';
        $message .= '</ol>';
        $message .= '<strong>Název společnosti:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Číslo účtu:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Kód třídění:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Zadejte číslo objednávky do sekce reference.<br>';
        $message .= 'Jakmile obdržíme vaši platbu, zpracujeme vaši objednávku a pošleme vám e-mail s potvrzením odeslání.<br><br>';
        $message .= '<strong>****POZOR, PLATBA MUSÍ BÝT ZOBRAZENA NA NAŠEM FIREMNÍM ÚČTU S PŘESNÝM MNOŽSTVÍM VAŠE OBJEDNÁVKY, VŠECHNY BANKOVNÍ POPLATKY MUSÍ BÝT POKRYTY VÁMI****</strong>';
    break;
    case 'sk':
        $subject = 'BACS platobné pokyny pre objednávku #' . $order->get_id();
        $message = 'Vážený ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Ďakujeme za vašu objednávku v celkovej výške ' . wc_price($order_total) . '. Postupujte podľa nižšie uvedených pokynov, aby ste dokončili platbu pomocou BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Prihláste sa do svojho účtu v internetovom bankovníctve.</li>';
        $message .= '<li>Vykonajte platbu na nasledujúci bankový účet:</li>';
        $message .= '</ol>';
        $message .= '<strong>Názov spoločnosti:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Číslo účtu:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Kód triedenia:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Zadajte číslo vašej objednávky do sekcie referencie.<br>';
        $message .= 'Po obdržaní vašej platby spracujeme vašu objednávku a pošleme vám e-mail s potvrdením odoslania.<br><br>';
        $message .= '<strong>****POZOR, PLATBA MUSÍ BYŤ ZOBRAZENÁ NA NAŠOM FIREMNOM ÚČTE S PRESNÝM MNOŽSTVOM VAŠEJ OBJEDNÁVKY, VŠETKY BANKOVÉ POPLATKY MUSIA BYŤ POKRYTÉ VAMI****</strong>';
    break;
    case 'hu':
        $subject = 'BACS fizetési utasítások a(z) #' . $order->get_id() . ' rendeléshez';
        $message = 'Kedves ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Köszönjük megrendelését, amelynek összege ' . wc_price($order_total) . '. Kérjük, kövesse az alábbi utasításokat a fizetés befejezéséhez a BACS használatával:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Jelentkezzen be az online banki fiókjába.</li>';
        $message .= '<li>Indítsa el a fizetést a következő bankszámlára:</li>';
        $message .= '</ol>';
        $message .= '<strong>Vállalat neve:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Bankszámlaszám:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sort Code:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Kérjük, adja meg a rendelési számát a hivatkozások részben.<br>';
        $message .= 'Miután megkaptuk a fizetését, feldolgozzuk a rendelését, és e-mailben elküldjük Önnek a szállítási visszaigazolást.<br><br>';
        $message .= '<strong>****KÉRJÜK, VEGYE FIGYELEMBE, HOGY A FIZETÉSNEK MEGJELENNIE KELL A CÉGES SZÁMLÁNKON A RENDELÉS PONTOS ÖSSZEGÉVEL, MINDEN BANKI DÍJAT ÖNNEK KELL FEDNIE****</strong>';
    break;
    case 'pl':
        $subject = 'Instrukcje płatności BACS dla zamówienia #' . $order->get_id();
        $message = 'Drogi ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Dziękujemy za zamówienie na łączną kwotę ' . wc_price($order_total) . '. Prosimy postępować zgodnie z poniższymi instrukcjami, aby zakończyć płatność za pomocą BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Zaloguj się do swojego konta bankowego online.</li>';
        $message .= '<li>Wykonaj płatność na następujące konto bankowe:</li>';
        $message .= '</ol>';
        $message .= '<strong>Nazwa firmy:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Numer konta:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Kod sortowania:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Proszę wpisać numer zamówienia w sekcji odniesienia.<br>';
        $message .= 'Po otrzymaniu płatności przetworzymy Twoje zamówienie i wyślemy Ci e-mail z potwierdzeniem wysyłki.<br><br>';
        $message .= '<strong>****PROSZĘ ZAUWAŻYĆ, ŻE PŁATNOŚĆ MUSI POJAWIĆ SIĘ NA NASZYM KONCIE FIRMOWYM Z DOKŁADNĄ KWOTĄ TWOJEGO ZAMÓWIENIA, WSZYSTKIE OPŁATY BANKOWE MUSZĄ BYĆ POKRYTE PRZEZ CIEBIE****</strong>';
    break;
    case 'nl':
        $subject = 'BACS-betalingsinstructies voor bestelling #' . $order->get_id();
        $message = 'Beste ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Bedankt voor uw bestelling met een totaal van ' . wc_price($order_total) . '. Volg de onderstaande instructies om uw betaling te voltooien met behulp van BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Log in op uw online bankrekening.</li>';
        $message .= '<li>Voer een betaling uit naar de volgende bankrekening:</li>';
        $message .= '</ol>';
        $message .= '<strong>Bedrijfsnaam:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Rekeningnummer:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sorteercode:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Vermeld uw bestelnummer in het gedeelte met de referentie.<br>';
        $message .= 'Zodra we uw betaling hebben ontvangen, verwerken we uw bestelling en sturen we u een e-mail met een verzendbevestiging.<br><br>';
        $message .= '<strong>****LET OP, DE BETALING MOET VERSCHIJNEN OP ONZE BEDRIJFSREKENING MET HET EXACTE BEDRAG VAN UW BESTELLING, ALLE BANKKOSTEN MOETEN WORDEN GEDRAGEN DOOR U****</strong>';
    break;
    case 'ga':
        $subject = 'Treoracha íocaíochta BACS don ordú #' . $order->get_id();
        $message = 'A chara ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Go raibh maith agat as do ordú le haghaidh iomlán ' . wc_price($order_total) . '. Déan na treoracha thíos a leanúint chun do íocaíocht a chríochnú ag baint úsáide as BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Logáil isteach i do chuntas bainc ar líne.</li>';
        $message .= '<li>Déan íocaíocht ar an gcuntas bainc seo a leanas:</li>';
        $message .= '</ol>';
        $message .= '<strong>Ainm an chuideachta:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Aonad Cuntas:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Cód Sórtála:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Cuir do chuid ordaithe san alt tagairt.<br>';
        $message .= 'Nuair a fhaigheann muid do íocaíocht, próiseálfaimid do ordú agus seolfaimid r-phost duit le deimhniú seachadta.<br><br>';
        $message .= '<strong>****TABHAIR FAOI DEARA, CAITHFIDH AN ÍOCAÍOCHT A BHEITH LE FEICEÁIL AR ÁR CUNTAS COMHLACHT LEIS AN MEASCTHAÍ ACHTÚ DO ORDÚ, CAITHFIDH GACH TÁILLÍ BAINC A BHEITH AGAT****</strong>';
    break;
    case 'lv':
        $subject = 'BACS maksājuma instrukcijas pasūtījumam #' . $order->get_id();
        $message = 'Dārgais ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Paldies par jūsu pasūtījumu kopējā summa ' . wc_price($order_total) . '. Lūdzu, ievērojiet zemāk norādītās instrukcijas, lai pabeigtu maksājumu, izmantojot BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Pierakstieties savā tiešsaistes bankas kontā.</li>';
        $message .= '<li>Veiciet maksājumu uz šādu bankas kontu:</li>';
        $message .= '</ol>';
        $message .= '<strong>Uzņēmuma nosaukums:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Konta numurs:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Kārtošanas kods:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Norādiet savu pasūtījuma numuru atsauces sadaļā.<br>';
        $message .= 'Saņemot jūsu maksājumu, mēs apstrādāsim jūsu pasūtījumu un nosūtīsim jums e-pasta paziņojumu par piegādi.<br><br>';
        $message .= '<strong>****LŪDZAM, PIEVĒRSIET UZMANĪBU, KA MAKSĀJUMAM JĀPARĀDĀS MŪSU UZŅĒMUMA KONTĀ AR JŪSU PASŪTĪJUMA PRECĪZU SUMMU, VISAS BANKAS MAKSAS JĀBŪT JŪSU****</strong>';
    break;
    case 'lt':
        $subject = 'BACS mokėjimo instrukcijos užsakymui #' . $order->get_id();
        $message = 'Brangus ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Dėkojame už jūsų užsakymą, kurio bendra suma ' . wc_price($order_total) . '. Norėdami užbaigti mokėjimą naudodami BACS, laikykitės žemiau pateiktų instrukcijų:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Prisijunkite prie savo internetinės banko sąskaitos.</li>';
        $message .= '<li>Atlikite mokėjimą į šią banko sąskaitą:</li>';
        $message .= '</ol>';
        $message .= '<strong>Įmonės pavadinimas:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Sąskaitos numeris:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Rūšiavimo kodas:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Nurodykite savo užsakymo numerį nuorodų skyriuje.<br>';
        $message .= 'Gavę mokėjimą, apdorosime jūsų užsakymą ir išsiųsime jums pristatymo patvirtinimo el. Laišką.<br><br>';
        $message .= '<strong>****PASTABA, KAD MOKĖJIMAS TURI BŪTI RODOMAS MŪSŲ ĮMONĖS SĄSKAITOJE SU JŪSŲ UŽSAKYMO TIKSLIU KIEKIU, VISI BANKO MOKĖJIMAI TURI BŪTI PADENGIMI JUMS****</strong>';
    break;
                
        // Add more cases for other languages here
        default:
            // Default to English if the order language is not supported
            $subject = 'BACS payment instructions for order #' . $order->get_id();
            $subject = 'BACS payment instructions for order #' . $order->get_id();
        $message = 'Dear ' . $order->get_billing_first_name() . ',<br><br>';
        $message .= 'Thank you for your order with a total of ' . wc_price($order_total) . '. Please follow the instructions below to complete your payment using BACS:<br><br>';
        $message .= '<ol>';
        $message .= '<li>Log in to your online banking account.</li>';
        $message .= '<li>Make a payment to the following bank account:</li>';
        $message .= '</ol>';
        $message .= '<strong>Company Name:</strong> <strong>' . $company_name . '</strong><br>';
        $message .= '<strong>Account Number:</strong> <strong>' . $account_number. '</strong><br>';
        $message .= '<strong>Sort Code:</strong> <strong>' . $sort_code. '</strong><br>';
        $message .= 'Please include your order number in the reference section.<br>';
        $message .= 'Once we have received your payment, we will process your order and send you a shipping confirmation email.<br><br>';
        $message .= '<strong>****PLEASE NOTE PAYMENT MUST APPEAR ON OUR COMPANY ACCOUNT WITH THE EXACT AMOUNT OF YOUR ORDER, ANY BANK CHARGES MUST BE COVERED BY YOU****</strong>';
    }

    // Send the email
    wc_mail($order->get_billing_email(), $subject, $message);
}
