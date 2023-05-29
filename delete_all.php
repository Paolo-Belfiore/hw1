<?php 

    require_once 'auth.php';

    if (!$userid = checkAuth()) {
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $userid = mysqli_real_escape_string($conn, $userid);
    
    $query = "DELETE FROM books where user_id = $userid";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    
    if (mysqli_affected_rows($conn) > 0) {
        header("Location: pagina_libreria.php");
    } else {
        header("Location: pagina_libreria.php");
    }
    
    mysqli_close($conn);

    exit;
?>