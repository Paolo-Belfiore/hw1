<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: pagina_accedi.php");
        exit;
    }
?>

<html>

    <head>
        <link rel = "stylesheet" href = "pagina_about.css"/>
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

        <header>
        </header>

        <section>
            <div id = "info-box">
                <div id = "elements-box">
                    <span id = "pwrd"> Powered by OpenLibrary API </span>
                    <span id = "author"> Autore: Paolo Belfiore </span>
                    <div id = "social">
                        <div class = "s" id = "ig"></div>
                        <div class = "s" id = "wa"></div>
                    </div>
                </div>
            </div>
        </section>

        <footer></footer>

    </body>

</html>