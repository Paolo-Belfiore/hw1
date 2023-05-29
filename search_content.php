<?php
    require_once 'auth.php';

    // Se la sessione è scaduta, esco
    if (!checkAuth()) exit;
    
    header("Content-Type: application/json");

    OpenLibrary();

    function OpenLibrary(){   
        // QUERY EFFETTIVA
        $query = urlencode($_GET["q"]);
        $url = 'http://openlibrary.org/search.json?q='.$query;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res=curl_exec($ch);
        curl_close($ch);
        echo $res;
    }
?>