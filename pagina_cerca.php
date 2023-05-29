<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: pagina_accedi.php");
        exit;
    }
?>

<html>

<?php 
    // Carico le informazioni dell'utente loggato per visualizzarle nella sidebar (mobile)
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $userid = mysqli_real_escape_string($conn, $userid);
    $query = "SELECT * FROM users WHERE id = $userid";
    $res_1 = mysqli_query($conn, $query);
    $userinfo = mysqli_fetch_assoc($res_1);   
  ?>

    <head>
        <link rel = "stylesheet" href = "pagina_cerca_contenuto.css"/>
        <meta name = "viewport" content = "device-width, initial-scale = 1">
        <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
        <script src = "pagina_cerca_contenuto.js" defer true></script>
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

        <section class = "empty">

            <div id = "search_box">  
                <form id = "search_form">
                    <h5 id = "tot"> Titolo/Autore </h5>
                    <input type = "text" name = "search" id = "search_bar" autocomplete = "off">
                    <input type = "submit" id = "s_button" value = "Cerca">
                </form>
            </div>
            <div id = "book-grid">
            </div>

        </section>

        <footer></footer>

    </body>

</html>
