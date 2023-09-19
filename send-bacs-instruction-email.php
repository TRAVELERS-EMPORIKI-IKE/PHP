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

Благодарим ви за вашата поръчка с обща сума " . wc_price($order_total) . ". Моля, следвайте инструкциите по-долу, за да завършите плащането си чрез BACS:

1. Влезте в акаунта си за онлайн банкиране.
2. Направете плащане по следната банкова сметка:

Име на фирмата: $company_name
Номер на сметката: $account_number
Код на сортиране: $sort_code

Моля, включете номера на вашата поръчка в раздела за справка.

След като получим вашето плащане, ние ще обработим вашата поръчка и ще ви изпратим имейл за потвърждение на доставката.

Благодаря ви за вашата поръчка.
****МОЛЯ, ОБЪРНЕТЕ ВНИМАНИЕ, че ПЛАЩАНЕТО ТРЯБВА ДА СЕ ПОЯВИ В НАШАТА ФИРМЕНА СМЕТКА С ТОЧНАТА СУМА НА ВАШАТА ПОРЪЧКА, ВСИЧКИ БАНКОВИ ТАКСИ ТРЯБВА ДА БЪДАТ ПОКРИТИ ОТ ВАС****";
            break;
		case 'hr':
            $subject = 'BACS upute za plaćanje za narudžbu #' . $order->get_id();
            $message = 'Dragi' . $order->get_billing_first_name() . ",

Zahvaljujemo na vašoj narudžbi s ukupnim iznosom " . wc_price($order_total) . ". Slijedite upute u nastavku kako biste dovršili plaćanje koristeći BACS:

1. Prijavite se na svoj račun za internet bankarstvo.
2. Izvršite uplatu na sljedeći bankovni račun:

Naziv tvrtke: $company_name
Broj računa: $account_number
Šifra sortiranja: $sort_code

Uključite svoj broj narudžbe u odjeljak s referencama.

Nakon što primimo vašu uplatu, obradit ćemo vašu narudžbu i poslati vam e-poruku s potvrdom dostave.

Hvala na Vašoj Narudžbi.
****MOLIMO IMAJTE NA VAŠU PLAĆANJE SE MORA POJAVITI NA RAČUNU NAŠE TVRTKE S TOČNIM IZNOSOM VAŠE NARUDŽBE, SVE BANKOVNE TROŠKOVE MORATE POKRITI VI****";
            break;
		case 'cs':
            $subject = 'Pokyny k platbě BACS pro objednávku #' . $order->get_id();
             $message = 'Vážený ' . $order->get_billing_first_name() . ",

Děkujeme za vaši objednávku v celkové výši " . wc_price($order_total) .". Pro dokončení platby pomocí BACS postupujte podle následujících pokynů:

1. Přihlaste se ke svému účtu online bankovnictví.
2. Proveďte platbu na následující bankovní účet:

Název společnosti: $company_name
Číslo účtu: $account_number
Třídicí kód: $sort_code

Do sekce reference uveďte číslo vaší objednávky.

Jakmile obdržíme vaši platbu, zpracujeme vaši objednávku a zašleme vám e-mail s potvrzením odeslání.

Děkujeme za Vaši objednávku.
****UPOZORŇUJEME, ŽE NA ÚČTU NAŠE FIRMY SE MUSÍ ZOBRAZIT PLATBA S PŘESNOU ČÁSTKOU VAŠÍ OBJEDNÁVKY, VŠECHNY BANKOVNÍ POPLATKY MUSÍTE HRADIT VY****";
            break;
        case 'en':
                $subject = 'BACS payment instructions for order #' . $order->get_id();
                $message = 'Dear ' . $order->get_billing_first_name() . ",
    
    Thank you for your order with a total of " . wc_price($order_total) . ". Please follow the instructions below to complete your payment using BACS:
    
    1. Log in to your online banking account.
    2. Make a payment to the following bank account:
    
    Company Name: $company_name
    Account Number: $account_number
    Sort Code: $sort_code
    
    Please include your order number in the reference section.
    
    Once we have received your payment, we will process your order and send you a shipping confirmation email.
    
    Thank you for your order.
    ****PLEASE NOTE PAYMENT MUST APPEAR ON OUR COMPANY ACCOUNT WITH THE EXACT AMOUNT OF YOUR ORDER, ANY BANK CHARGES MUST BE COVERED BY YOU****";
		break;
    case 'et':
        $subject = 'BACS-i maksejuhised tellimuse # jaoks' . $order->hangi_id();
        $message = 'Kallis' . $order->hangi_arvelduse_eesnimi() . ",

Täname teid tellimuse eest kogusummaga " . wc_price($order_total) . ". BACS-i abil makse sooritamiseks järgige allolevaid juhiseid.

1. Logige sisse oma internetipanga kontole.
2. Tehke makse järgmisele pangakontole:

Ettevõtte nimi: $company_name
Kontonumber: $account_number
Sortimiskood: $sort_code

Palun lisage viiteosale oma tellimuse number.

Kui oleme teie makse kätte saanud, töötleme teie tellimust ja saadame teile kohaletoimetamise kinnitusmeili.

Täname tellimuse eest.
****PANGE TÄHELEPANU, ET MAKSE PEAB ILMA MEIE ETTEVÕTTE KONTOLE KOOS TEIE TELLIMUSE TÄPSEMA SUMMAGA, KÕIK PANGATASU PEATE KATTAMA TEIE****";
     break;
    case 'fi':
        $subject = 'BACS-maksuohjeet tilaukselle #' . $order->get_id();
        $message = 'Hyvä ' . $order->get_billing_first_name() . ",

Kiitos tilauksestasi yhteensä " . wc_price($order_total) . ". Seuraa alla olevia ohjeita suorittaaksesi maksun BACS: n avulla:

1. Kirjaudu sisään verkkopankkitilillesi.
2. Tee maksu seuraavalle pankkitilille:

Yrityksen nimi: $company_name
Tilinumero: $account_number
Lajittelukoodi: $sort_code

Sisällytä tilausnumerosi viiteosioon.

Kun olemme vastaanottaneet maksun, käsittelemme tilauksesi ja lähetämme sinulle toimitusvahvistuksen sähköpostitse.

Kiitos tilauksestasi.
****HUOMAA, ETTÄ MAKSU ON NÄYTETTÄVÄ YRITYKSEMME TILILLÄ TARKALLA SUMMALLA TILAUKSESTASI, KAIKKI PANKKIMAKSUT ON KATETTAVA SINULLE****";
    break;
    case 'fr':
        $subject = 'Instructions de paiement BACS pour la commande #' . $order->get_id();
        $message = 'Cher ' . $order->get_billing_first_name() . ",

Merci pour votre commande d'un montant total de " . wc_price($order_total) . ". Veuillez suivre les instructions ci-dessous pour effectuer votre paiement en utilisant BACS:

1. Connectez-vous à votre compte bancaire en ligne.
2. Effectuez un paiement sur le compte bancaire suivant:

Nom de la société: $company_name
Numéro de compte: $account_number
Code de tri: $sort_code

Veuillez inclure votre numéro de commande dans la section référence.

Une fois que nous aurons reçu votre paiement, nous traiterons votre commande et vous enverrons un e-mail de confirmation d'expédition.

Merci pour votre commande.
****VEUILLEZ NOTER QUE LE PAIEMENT DOIT APPARAÎTRE SUR NOTRE COMPTE D'ENTREPRISE AVEC LE MONTANT EXACT DE VOTRE COMMANDE, TOUTES LES FRAIS BANCAIRES DOIVENT ÊTRE COUVERTES PAR VOUS****";
    break;
    case 'de':
        $subject = 'BACS-Zahlungsanweisungen für Bestellung #' . $order->get_id();
        $message = 'Lieber ' . $order->get_billing_first_name() . ",

Vielen Dank für Ihre Bestellung in Höhe von " . wc_price($order_total) . ". Bitte befolgen Sie die folgenden Anweisungen, um Ihre Zahlung mit BACS abzuschließen:

1. Melden Sie sich bei Ihrem Online-Banking-Konto an.
2. Tätigen Sie eine Zahlung auf das folgende Bankkonto:

Firmenname: $company_name
Kontonummer: $account_number
Sortiercode: $sort_code

Bitte geben Sie Ihre Bestellnummer im Referenzbereich an.

Sobald wir Ihre Zahlung erhalten haben, werden wir Ihre Bestellung bearbeiten und Ihnen eine Versandbestätigungs-E-Mail senden.

Vielen Dank für Ihre Bestellung.
****BITTE BEACHTEN SIE, DASS DIE ZAHLUNG MIT DEM EXAKTEN BETRAG IHRER BESTELLUNG AUF UNSEREM FIRMENKONTO ERFOLGEN MUSS, ALLE BANKGEBÜHREN MÜSSEN VON IHNEN GETRAGEN WERDEN****";
    break;
    case 'el':
        $subject = 'Οδηγίες πληρωμής BACS για παραγγελία #' . $order->get_id();
        $message = 'Αγαπητέ ' . $order->get_billing_first_name() . ",

Σας ευχαριστούμε για την παραγγελία σας συνολικού ποσού " . wc_price($order_total) . ". Ακολουθήστε τις παρακάτω οδηγίες για να ολοκληρώσετε την πληρωμή σας χρησιμοποιώντας το BACS:

1. Συνδεθείτε στο λογαριασμό σας στην τραπεζική σας τράπεζα.
2. Κάντε μια πληρωμή στον ακόλουθο τραπεζικό λογαριασμό:

Όνομα εταιρείας: $company_name
Αριθμός λογαριασμού: $account_number
Κωδικός ταξινόμησης: $sort_code

Παρακαλούμε συμπεριλάβετε τον αριθμό παραγγελίας σας στην ενότητα αναφοράς.

Μόλις λάβουμε την πληρωμή σας, θα επεξεργαστούμε την παραγγελία σας και θα σας στείλουμε ένα email επιβεβαίωσης αποστολής.

Σας ευχαριστούμε για την παραγγελία σας.
****ΠΑΡΑΚΑΛΩ ΣΗΜΕΙΩΣΤΕ ΟΤΙ Η ΠΛΗΡΩΜΗ ΠΡΕΠΕΙ ΝΑ ΕΜΦΑΝΙΣΤΕΙ ΣΤΟΝ ΛΟΓΑΡΙΑΣΜΟ ΤΗΣ ΕΤΑΙΡΕΙΑΣ ΜΑΣ ΜΕ ΤΟ ΑΚΡΙΒΕΣ ΠΟΣΟ ΤΗΣ ΠΑΡΑΓΓΕΛΙΑΣ ΣΑΣ, ΟΠΟΙΕΣ ΤΡΑΠΕΖΙΚΕΣ ΧΡΕΩΣΕΙΣ ΠΡΕΠΕΙ ΝΑ ΚΑΛΥΦΘΟΥΝ ΑΠΟ ΕΣΑΣ****";
    break;
    case 'hu':
        $subject = 'BACS fizetési utasítások a(z) #' . $order->get_id() . ' rendeléshez';
        $message = 'Kedves ' . $order->get_billing_first_name() . ",

Köszönjük megrendelését, amelynek összege " . wc_price($order_total) . ". Kérjük, kövesse az alábbi utasításokat a fizetés befejezéséhez a BACS használatával:

1. Jelentkezzen be az online banki fiókjába.
2. Fizessen a következő bankszámlára:

Cégnév: $company_name
Számlaszám: $account_number
Rendezési kód: $sort_code

Kérjük, adja meg rendelési számát a hivatkozások részben.

Miután megkaptuk a fizetését, feldolgozzuk a rendelését, és e-mailben elküldjük Önnek a szállítási visszaigazolást.

Köszönjük a rendelését.
****KÉRJÜK, VEGYE FIGYELEMBE, HOGY A FIZETÉSNEK MEGJELENNIE KELL A CÉG SZÁMLÁJÁN A RENDELÉS PONTOS ÖSSZEGÉVEL, A BANKI DÍJAKAT ÖNNEK KELL FEDNI****";
    break;
    case 'it':
        $subject = 'Istruzioni per il pagamento BACS per l\'ordine #' . $order->get_id();
        $message = 'Caro ' . $order->get_billing_first_name() . ",

Grazie per il tuo ordine per un totale di " . wc_price($order_total) . ". Segui le istruzioni di seguito per completare il pagamento utilizzando BACS:

1. Accedi al tuo account bancario online.
2. Effettua un pagamento sul seguente conto bancario:

Nome azienda: $company_name
Numero di conto: $account_number
Codice di ordinamento: $sort_code

Includi il numero del tuo ordine nella sezione riferimento.

Una volta ricevuto il pagamento, elaboreremo il tuo ordine e ti invieremo una e-mail di conferma della spedizione.

Grazie per il tuo ordine.
****NOTA BENE CHE IL PAGAMENTO DEVE APPARIRE SUL NOSTRO CONTO AZIENDALE CON L'IMPORTO ESATTO DEL TUO ORDINE, EVENTUALI SPESE BANCARIE DEVONO ESSERE COPIATE DA TE****";
    break;
    case 'lv':
        $subject = 'BACS maksājuma instrukcijas pasūtījumam #' . $order->get_id();
        $message = 'Dārgais ' . $order->get_billing_first_name() . ",

Paldies par jūsu pasūtījumu ar kopējo summu " . wc_price($order_total) . ". Lai pabeigtu maksājumu, izmantojot BACS, ievērojiet zemāk norādītās instrukcijas:

1. Piesakieties savā tiešsaistes bankas kontā.
2. Veiciet maksājumu uz sekojošo bankas kontu:

Uzņēmuma nosaukums: $company_name
Konta numurs: $account_number
Kārtošanas kods: $sort_code

Lūdzu, iekļaujiet savu pasūtījuma numuru atsauce sadaļā.

Saņemot jūsu maksājumu, mēs apstrādāsim jūsu pasūtījumu un nosūtīsim jums paziņojumu par piegādi.

Paldies par jūsu pasūtījumu.
****LŪDZU, PIEVĒRSIET UZMANĪBU, KA MAKSĀJUMAM JĀPARĀDĀS MŪSU UZŅĒMUMA KONTĀ AR JŪSU PASŪTĪJUMA PAREIZO SUMMU, JEBKURAS BANKAS MAKSAS JĀSEDZ JŪS****";
    break;
    case 'lt':
        $subject = 'BACS mokėjimo instrukcijos užsakymui #' . $order->get_id();
        $message = 'Brangus ' . $order->get_billing_first_name() . ",

Dėkojame už jūsų užsakymą, kurio bendra suma " . wc_price($order_total) . ". Norėdami užbaigti mokėjimą naudodami BACS, laikykitės žemiau pateiktų instrukcijų:

1. Prisijunkite prie savo internetinės bankininkystės sąskaitos.
2. Atlikite mokėjimą į šią banko sąskaitą:

Įmonės pavadinimas: $company_name
Sąskaitos numeris: $account_number
Rūšiavimo kodas: $sort_code

Prašome įtraukti savo užsakymo numerį nuorodos skyriuje.

Gavę jūsų mokėjimą, mes apdorosime jūsų užsakymą ir išsiųsime jums pristatymo patvirtinimo el. Laišką.

Dėkojame už jūsų užsakymą.
****PASTABA, KAD MOKĖJIMAS TURI PASIRODYTI MŪSŲ ĮMONĖS SĄSKAITOJE SU JŪSŲ UŽSAKYMO TIKSLIU KIEKIU, BET KOKIŲ BANKO MOKESČIŲ TURI BŪTI PADENGTA JUMS****";
    break;
    case 'pt-pt':
        $subject = 'Instruções de pagamento BACS para o pedido #' . $order->get_id();
        $message = 'Caro ' . $order->get_billing_first_name() . ",

Obrigado pelo seu pedido com um total de " . wc_price($order_total) . ". Siga as instruções abaixo para concluir o pagamento usando BACS:

1. Faça login na sua conta bancária online.
2. Faça um pagamento para a seguinte conta bancária:

Nome da empresa: $company_name
Número da conta: $account_number
Código de classificação: $sort_code

Inclua o número do seu pedido na seção de referência.

Assim que recebermos seu pagamento, processaremos seu pedido e enviaremos um e-mail de confirmação de envio.

Obrigado pelo seu pedido.
****OBSERVE QUE O PAGAMENTO DEVE APARECER NA CONTA DA NOSSA EMPRESA COM O VALOR EXATO DO SEU PEDIDO, QUALQUER TAXA BANCÁRIA DEVE SER COBERTA POR VOCÊ****";
    break;
    case 'pl':
        $subject = 'Instrukcje płatności BACS dla zamówienia #' . $order->get_id();
        $message = 'Drogi ' . $order->get_billing_first_name() . ",

Dziękujemy za zamówienie na łączną kwotę " . wc_price($order_total) . ". Prosimy postępuj zgodnie z poniższymi instrukcjami, aby zakończyć płatność za pomocą BACS:

1. Zaloguj się do swojego konta bankowego online.
2. Dokonaj płatności na następujące konto bankowe:

Nazwa firmy: $company_name
Numer konta: $account_number
Kod sortowania: $sort_code

Proszę umieścić numer zamówienia w sekcji odniesienia.

Po otrzymaniu płatności przetworzymy Twoje zamówienie i wyślemy Ci e-mail z potwierdzeniem wysyłki.

Dziękujemy za zamówienie.
****PAMIĘTAJ, ŻE PŁATNOŚĆ MUSI ZOSTAĆ NA KONCIE FIRMOWYM DOKŁADNIE KWOTĄ TWOJEGO ZAMÓWIENIA. WSZELKIE OPŁATY BANKOWE MUSISZ BYĆ POKRYTE PRZEZ CIEBIE****";
    break;
    case 'ga':
        $subject = 'Treoracha íocaíochta BACS don ordú #' . $order->get_id();
        $message = 'A chara ' . $order->get_billing_first_name() . ",

Go raibh maith agat as do ordú le haghaidh iomlán " . wc_price($order_total) . ". Déan iarracht na treoracha thíos a leanúint chun do íocaíocht a chríochnú ag baint úsáide as BACS:

1. Logáil isteach i do chuntas bainc ar líne.
2. Déan íocaíocht ar an gcuntas bainc seo a leanas:

Ainm an chuideachta: $company_name
Uimhir cuntas: $account_number
Cód socrúcháin: $sort_code

Cuir do uimhir ordaithe san alt tagairt.

Nuair a fhaigheann muid do íocaíocht, próiseálfaimid do ordú agus seolaimid r-phost deimhnithe seachadta chugat.

Go raibh maith agat as do ordú.
****NÓTAIGH GO GCAITHFIDH AN ÍOCAÍOCHT A BHEITH AR ÁR CUNTAS COMHLACHT LEIS AN LÍON TOCHTACH A BHEITH AG DO ORDÚ, CAITHFIDH GACH TÁILLÍ BAINC A BHEITH AGAT****";
    break;
    case 'ro':
        $subject = 'Instrucțiuni de plată BACS pentru comanda #' . $order->get_id();
        $message = 'Dragă ' . $order->get_billing_first_name() . ",

Vă mulțumim pentru comanda dvs. cu o sumă totală de " . wc_price($order_total) . ". Vă rugăm să urmați instrucțiunile de mai jos pentru a vă finaliza plata folosind BACS:

1. Conectați-vă la contul dvs. bancar online.
2. Efectuați o plată în contul bancar următor:

Nume companie: $company_name
Număr de cont: $account_number
Cod de sortare: $sort_code

Vă rugăm să includeți numărul comenzii dvs. în secțiunea de referință.

Odată ce am primit plata dvs., vom procesa comanda dvs. și vă vom trimite un e-mail de confirmare a expedierii.

Vă mulțumim pentru comanda dvs.
****VĂ RUGĂM SĂ REȚINEȚI CĂ PLATA TREBUIE SĂ APARĂ PE CONTUL FIRMEI NOASTRE CU SUMA EXACTĂ A COMENZII DVS., ORICE TAXE BANCARE TREBUIE SĂ FIE ACOPERITE DE DVS.****";
    break;
    case 'sk':
        $subject = 'Pokyny k platbe BACS pre objednávku #' . $order->get_id();
        $message = 'Vážený ' . $order->get_billing_first_name() . ",
        
Ďakujeme za vašu objednávku v celkovej výške " . wc_price($order_total) . ". Pre dokončenie platby pomocou BACS postupujte podľa nasledujúcich pokynov:

1. Prihláste sa do svojho účtu online bankovníctva.
2. Vykonajte platbu na nasledujúci bankový účet:

Názov spoločnosti: $company_name
Číslo účtu: $account_number
Triediaci kód: $sort_code

Do sekcie referencie uveďte číslo vašej objednávky.

Po obdržaní vašej platby spracujeme vašu objednávku a zašleme vám e-mail s potvrdením o doručení.

Ďakujeme za Vašu objednávku.
****UPOZORNENIE, ŽE PLATBA MUSÍ BYŤ ZOBRAZENÁ NA ÚČTE NAŠEJ SPOLOČNOSTI S PRESNÝM MNOŽSTVOM VAŠEJ OBJEDNÁVKY, VŠETKY BANKOVÉ POPLATKY MUSIA BYŤ POKRYTÉ VAMI****";
    break;
    case 'sl':
        $subject = 'Navodila za plačilo BACS za naročilo #' . $order->get_id();
        $message = 'Dragi ' . $order->get_billing_first_name() . ",

Hvala za vaše naročilo v skupni višini " . wc_price($order_total) . ". Sledite spodnjim navodilom, da zaključite plačilo z uporabo BACS:

1. Prijavite se v svoj spletni bančni račun.
2. Izvedite plačilo na naslednji bančni račun:

Ime podjetja: $company_name
Številka računa: $account_number
Koda za razvrščanje: $sort_code

V razdelek sklic vključite številko naročila.

Ko prejmemo vaše plačilo, bomo obdelali vaše naročilo in vam poslali e-poštno sporočilo o potrditvi pošiljanja.

Hvala za vaše naročilo.
****OPOMBA, DA SE MORA PLAČILO POJAVITI NA NAŠEM RAČUNU PODJETJA Z NATANČNIM ZNESEKOM VAŠEGA NAROČILA, VSE BANČNE PRISTOJNOSTI MORAJO BITI POKRITE Z VAMI****";
    break;
    case 'sv':
        $subject = 'BACS betalningsinstruktioner för beställning #' . $order->get_id();
        $message = 'Kära ' . $order->get_billing_first_name() . ",

Tack för din beställning med ett totalt belopp på " . wc_price($order_total) . ". Följ instruktionerna nedan för att slutföra din betalning med BACS:

1. Logga in på ditt onlinebankkonto.
2. Gör en betalning till följande bankkonto:

Företagsnamn: $company_name
Kontonummer: $account_number
Sorteringskod: $sort_code

Ange ditt beställningsnummer i referensavsnittet.

När vi har mottagit din betalning kommer vi att behandla din beställning och skicka dig ett e-postmeddelande med bekräftelse på leverans.

Tack för din beställning.
****OBSERVERA ATT BETALNINGEN MÅSTE VISAS PÅ VÅR FÖRETAGSKONTO MED EXAKT BELOPP AV DIN BESTÄLLNING, ALLA BANKKOSTNADER MÅSTE VARA TÄCKT AV DIG****";
    break;
    case 'es':
        $subject = 'Instrucciones de pago BACS para el pedido #' . $order->get_id();
        $message = 'Estimado ' . $order->get_billing_first_name() . ",

Gracias por su pedido con un total de " . wc_price($order_total) . ". Siga las instrucciones a continuación para completar su pago con BACS:

1. Inicie sesión en su cuenta bancaria en línea.
2. Realice un pago a la siguiente cuenta bancaria:

Nombre de la empresa: $company_name
Número de cuenta: $account_number
Código de clasificación: $sort_code

Incluya el número de su pedido en la sección de referencia.

Una vez que hayamos recibido su pago, procesaremos su pedido y le enviaremos un correo electrónico de confirmación de envío.

Gracias por su pedido.
****TENGA EN CUENTA QUE EL PAGO DEBE APARECER EN NUESTRA CUENTA DE EMPRESA CON EL MONTO EXACTO DE SU PEDIDO, CUALQUIER CARGO BANCARIO DEBE SER CUBIERTO POR USTED****";
    break;
        // Add more cases for other languages here
        default:
            // Default to English if the order language is not supported
            $subject = 'BACS payment instructions for order #' . $order->get_id();
            $message = 'Dear ' . $order->get_billing_first_name() . ",

Thank you for your order with a total of " . wc_price($order_total) . ". Please follow the instructions below to complete your payment using BACS:

1. Log in to your online banking account.
2. Make a payment to the following bank account:

Company Name: $company_name
Account Number: $account_number
Sort Code: $sort_code

Please include your order number in the reference section.

Once we have received your payment, we will process your order and send you a shipping confirmation email.

Thank you for your order.
****PLEASE NOTE PAYMENT MUST APPEAR ON OUR COMPANY ACCOUNT WITH THE EXACT AMOUNT OF YOUR ORDER, ANY BANK CHARGES MUST BE COVERED BY YOU****";
    }

    // Send the email
    wc_mail($order->get_billing_email(), $subject, $message);
}
