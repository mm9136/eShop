<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Avtorizacija na podlagi polj certifikata X.509</title>
    </head>
    <body>
        <?php
        
        
        $authorized_users = [$_SESSION["user"]["email"]];
        

        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        if ($client_cert == null) {
            die('err: Spremenljivka SSL_CLIENT_CERT ni nastavljena.');
        }


        $cert_data = openssl_x509_parse($client_cert);
        $username = $cert_data['subject']['CN'];
        $commonname = (is_array($cert_data['subject']['emailAddress']) ?
                        $cert_data['subject']['emailAddress'][0] : $cert_data['subject']['emailAddress']);
        if (in_array($commonname, $authorized_users)) {
            
            ViewHelper::redirect(BASE_URL . "store");
            
        } else {
            $_SESSION["user"] = NULL;
            ViewHelper::redirect(BASE_URL . "login");
        }


   
        ?>
    </body>
</html>
