<?php
    // 1) Controlliamo che l'utente sia già loggato, in modo da reindirizzarlo direttamente alla home page

    include "auth.php";

    if(checkAuth()){
        header("Location: pagina_profilo.php");
        exit;
    }

    // 2) Controlliamo l'invio dei dati inseriti dall'utente
    
    if(!empty($_POST["username"]) && !empty($_POST["password"])){
        /*  2.a) Connessione al DataBase in caso di invio corretto dei dati*/
        $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die(mysqli_error($conn));
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        /*  2.b) Effettuiamo la query al DataBase e ritorniamo la risposta */
        $query = "SELECT * FROM users WHERE username = '$username'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        /*  2.c) Controlliamo i risultati restituiti dal DataBase */
        if(mysqli_num_rows($res) > 0){
            $entry = mysqli_fetch_assoc($res);
            if(password_verify($_POST["password"], $entry["password"])){
                /*  2.d) Imposto la sessione per l'utente */    
                $_SESSION["_bt_username"] = $entry["username"];
                $_SESSION["_bt_user_id"] = $entry["id"];
                /*  Reindirizziamo l'utente verso la pagina specifica */
                header("Location: pagina_profilo.php");
                mysqli_free_results($res);
                mysqli_close($conn);
            }
        }
        /*  2.e) Mostriamo un errore nel caso in cui l 'utente non esista
                 o non ha inserito correttamentre le credenziali */
        $error = "Credenziali non valide!";
    }
    /*  2.f) Controlliamo quali campi sono stati riempiti e in caso
             mostriamo l'errore di completamento */
    else if(isset($_POST["username"]) || isset($_POST["password"])){
        $error = "Completa tutti i campi!";
    }
?>


<html>

    <head>
        <title> BookTime - Accedi </title>
        <link rel = "stylesheet" href = "pagina_accedi.css"/>
        <meta name = "viewport" content = "device-width, initial-scale = 1">
        <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
    </head>

    <body>

        <header>
            <div id = "hd_img_1">
                <img src = "header_bg2.jpg">
            </div>
            <div id = "hd_text">
                <a href = "index.php"> BookTime </a>
            </div>
            <div id = "hd_img_2">
                <img src = "header_bg2.jpg">
            </div>
        </header>

        <section>
            <div id = "log-box">

                <form id = "credentials" method = "post">
                    <label> Username </label>
                    <input type = "text" name = "username" id = "username" autocomplete = "off" <?php if(isset($_POST["username"])){ echo "value=".$_POST["username"];}   ?>>
                    <label > Password</label>
                    <input type = "password" name = "password" id = "password" autocomplete = "off" <?php if(isset($_POST["password"])){ echo "value=".$_POST["password"];}   ?>>
                    <input type = "submit" id = "accedi-bt" value = "Accedi">
                </form>
                
                <div id = "red-box">
                <?php
                    /*  2.g) Controlliamo la presenza di errori */
                    if(isset($error)){
                        echo "<p class = 'error'> $error </p> ";
                    }
                ?>
                    <p> Non ti sei ancora registrato? Nessun problema. 
                        Crea subito un account gratuito!
                    </p>
                    <a href = "pagina_registrati.php" id = "red_registrati"> REGISTRATI </a>
                </div>
            </div>
        </section>


    </body>

</html>