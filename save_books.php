<?php

    require_once 'auth.php';

    if (!$userid = checkAuth()) {
        exit;
    }
    
    OpenLibrary();


    function OpenLibrary(){
        //  1)Connessione al DataBase
        global $dbconfig, $userid;
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        //  2)Costruzione della query
        $userid = mysqli_real_escape_string($conn, $userid);
        $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $author = mysqli_real_escape_string($conn, $_POST['author']);
        $cover = mysqli_real_escape_string($conn, $_POST['cover']);
        //  3)Controllo la presenza dello stesso libro sul DataBase
        $query = "SELECT * FROM books WHERE user_id = '$userid' AND book_isbn = '$isbn'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        //  3.a)In caso di esito positivo, il libro non viene aggiunto
        if(mysqli_num_rows($res) > 0) {
            echo json_encode(array('ok' => true));
            exit;
        }
        // 3.b)In caso negativo, aggiungo il libro al DataBase
        $query = "INSERT INTO books(user_id, book_isbn, book_title, book_author, book_cover) VALUES('$userid','$isbn', '$title', '$author', '$cover')";
        error_log($query);
        //  3.c)Se corretta, ritorna un JSON con {ok: true}
        if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
            echo json_encode(array('ok' => true));
            exit;
        }
    }

?>