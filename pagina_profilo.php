<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: pagina_accedi.php");
        exit;
    }
?>

<html>

    <?php 
         // Carico le informazioni dell'utente loggato per poterle visualizzare
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?>

    <head>
        <link rel = "stylesheet" href = "pagina_profilo.css"/>
        <meta name = "viewport" content = "device-width, initial-scale = 1">
        <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
    </head>

    <body>

        <nav>
            <a href="#" id = "name"> BookTime </a>
            <a href = "pagina_cerca.php" > Cerca </a>
            <a href="pagina_libreria.php"> Libreria </a>
            <a href="pagina_profilo.php"> Profilo </a>
            <a href="pagina_about.php" id = "about"> About </a>
            <a href="esci.php" id = "esci"> Esci </a>
        </nav>

        <header></header>

        <section>
            <div id = "profile_info">
                <div id = "profile_pic">
                    <img src = "user.png">
                </div>
                <h2> Le tue info </h2>
                <div id = "info">
                    <div id = "labels">
                        <label name = "nome"> Nome: </label>
                        <label name = "username"> Username: </label>
                        <label name = "email"> Email: </label>
                    </div>
                    <div id = "user_info">
                        <label name = "nome_db"><?php echo $userinfo['name']?></label>
                        <label name = "username_db"><?php echo $userinfo['username']?></label>
                        <label name = "email_db"><?php echo $userinfo['email']?></label>
                    </div>
                </div>
            </div>
        </section>

        <footer></footer>

    </body>

</html>

<?php mysqli_close($conn); ?>