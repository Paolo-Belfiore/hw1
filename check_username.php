<?php 
/*  Eseguiamo un controllo affinché lo username sia unico */


    require_once 'dbconfig.php';
    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        exit;
    }
    /*  1) Impostiamo l'header della risposta e ci connettiamo al DataBase  */
    header('Content-Type: application/json');
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    /*  2) Leggiamo la stringa dello username */
    $username = mysqli_real_escape_string($conn, $_GET["q"]);
    /*  3) Costruiamo la query e la eseguiamo */
    $query = "SELECT username FROM users WHERE username = '$username'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    // Tornerà un JSON con chiave exists e valore boolean
    echo json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));
    /*  4) Chiudiamo la connessione */
    mysqli_close($conn);
?>