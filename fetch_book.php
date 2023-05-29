<?php 

    require_once 'auth.php';

    if (!$userid = checkAuth()) {
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $userid = mysqli_real_escape_string($conn, $userid);
    
        // Seleziono tutti gli attributi che mi interessano
        // (EXISTS) Mi faccio ritornare i like se ce ne sono
        // (FROM) Dall'unione tra i post e gli utenti (tutti gli utenti che hanno pubblicato post)

    $query = "SELECT user_id AS user, book_isbn AS isbn, book_title AS title, book_author AS author, book_cover as cover from books where user_id = $userid ORDER BY title";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    
    $bookArray = array();

    while($entry = mysqli_fetch_assoc($res)) {
        // Scorro i risultati ottenuti e creo l'elenco di post
        $bookArray[] = array('user' => $entry['user'],
                            'isbn' => $entry['isbn'], 
                            'title' => $entry['title'],
                            'author' => $entry['author'],
                            'cover' => $entry['cover'],
                            );
    }
    echo json_encode($bookArray);
    
    exit;
?>