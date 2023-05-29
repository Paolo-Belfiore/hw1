<?php
    /*Controlla che l'utente sia già autenticato*/
    require_once 'dbconfig.php';
    session_start();

    function checkAuth() {
        // Controllo la sessione e se esiste la ritorno, altrimenti ritorno 0
        if(isset($_SESSION['_bt_user_id'])) {
            return $_SESSION['_bt_user_id'];
        } else 
            return 0;
    }
?>