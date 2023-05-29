<?php
    // 1) Controlliamo che l'utente sia già loggato, in modo da reindirizzarlo direttamente alla home page
    require_once 'auth.php';

    if(checkAuth()){
        header("Location: pagina_profilo.php");
        exit;
    }

    // 2) Controlliamo l'invio dei dati inseriti dall'utente

    if (!empty($_POST["name"]) && !empty($_POST["username"]) && !empty($_POST["email"]) && 
        !empty($_POST["password"]) && !empty($_POST["confirm_password"])){
            /*  2.a) Creiamo un array che conterrà tutti gli errori presenti in fase di compilazione */
            $error = array();
            /*  2.b) Connessione al DataBase in caso di invio corretto dei dati */
            $conn = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["name"]) or die(mysqli_error($conn));
            /*  2.c) Controlli sui vari campi */
            // Username
            if(!preg_match("/^[a-zA-Z0-9_]{1,15}$/", $_POST["username"])){
                $error[] = "Username non valido!";
            }
            else{
                // Effettuiamo l'escape string del campo e controlliamo se esiste già nel DataBase
                $username = mysqli_real_escape_string($conn, $_POST["username"]);
                $query = "SELECT * FROM users WHERE username = '$username'";
                $res = mysqli_query($conn, $query);
                if(mysqli_num_rows($res) > 0){
                    $error[] = "Username attualmente in uso!";
                }
            }
            // Password
            // Contiamo la lunghezza affinchè sia uguale a quella richiesta
            if(strlen($_POST["password"]) < 8){
                $error[] = "Lunghezza password insufficiente!";
            }
            // Confrontiamo la password di conferma con quella inserita poco prima, sollevando in caso l'errore
            if(strcmp($_POST["password"], $_POST["confirm_password"]) != 0){
                $error[] = "Le password non coincidono!";
            }
            // Email
            // Assicuriamoci che l'email abbia un formato valido
            if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                $error[] = "Email non valida!";
            }
            // Effettuiamo l'escape string del campo e controlliamo se esiste già nel DataBase
            $email = mysqli_real_escape_string($conn, strtolower($_POST["email"]));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if(mysqli_num_rows($res) > 0){
                $error[] = "Email attualmente in uso!";
            }
            /*  2.e) Registrazione nel DataBase */
            if(count($error) == 0){
                // Eseguiamo l'escape string di tutti i campi compilati
                $name = mysqli_real_escape_string($conn, $_POST["name"]);
                $username = mysqli_real_escape_string($conn, $_POST["username"]);
                $password = mysqli_real_escape_string($conn, $_POST["password"]);
                // Eseguiamo l'hash della paswword in modo che venga cifrata sul DataBase
                $password = password_hash($password, PASSWORD_BCRYPT);
                // Creiamo la query per inserire l'utente nel DataBase
                $query = "INSERT INTO users(name, username, email, password) VALUES('$name', '$username', '$email', '$password')";
                if(mysqli_query($conn, $query)){
                    $_SESSION["_bt_username"] = $_POST["username"];
                    $_SESSION["_bt_user_id"] = mysqli_insert_id($conn);
                    mysqli_close($conn);
                    header("Location: pagina_profilo.php");
                    exit;
                }
                else{
                    $error[] = "Errore di connessione al DataBase!";
                }
            }
            mysqli_close($conn);
        }
        else if(isset($_POST["username"])){
            $error = array("Riempi tutti i campi!");
        }
?>



<html>

    <head>
        <title> BookTime - Registrati </title>
        <link rel = "stylesheet" href = "pagina_registrati.css"/>
        <meta name = "viewport" content = "device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
        <script src = "pagina_registrati.js" defer true ></script>
    </head>

    <body>

        <header>
            <div id = "hd_img_1">
                <img src = "header_bg2.jpg">
            </div>
            <div id = "hd_text">
                <a href = "index.php"> BookTime</a>
            </div>
            <div id = "hd_img_2">
                <img src = "header_bg2.jpg">
            </div>
        </header>

        <section>
            <div id = "log-box">
                <form id = "credentials" method = "post">
                    <label> Nome </label>
                    <input type = "text" id = "new_name" name = "name" autocomplete = "off" <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?>>
                    <label> Username </label>
                    <input type = "text" id = "new_username" name = "username" autocomplete = "off" <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                    <label> Email </label>
                    <input type = "text" id = "new_email" name = "email" autocomplete = "off" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                    <label > Password</label>
                    <input type = "password" id = "new_password" placeholder="Lunghezza minima: 8 caratteri" name = "password" autocomplete = "off" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                    <label > Conferma Password</label>
                    <input type = "password" id = "new_password_2" name = "confirm_password" autocomplete = "off">
                    <input type = "submit" id = "registrati-bt" value = "Registrati">
                    <?php 
                        if(isset($error)) {
                            foreach($error as $err) {
                                echo "<div class='error'><span>".$err."</span></div>";
                            }
                        } 
                    ?>
                </form>
                <div id = "red-box">
                    <span> Sei già un utente presso la nostra piattaforma? </span>
                    <a href = "pagina_accedi.php" id = "red_accedi"> ACCEDI </a>
                </div>
            </div>
        </section>

    </body>

</html>