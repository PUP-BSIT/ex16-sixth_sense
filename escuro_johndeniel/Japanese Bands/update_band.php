<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $date_formed = $_POST['date_formed'] ?? null;
    $best_hit_album = $_POST['best_hit_album'] ?? null;
    $genre = $_POST['genre'] ?? null;
    
    if ($id && $name && $date_formed && $best_hit_album && $genre) {
        $stmt = $mysqli->prepare(
            "UPDATE japanese_bands 
            SET name=?, date_formed=?, best_hit_album=?, genre=? 
            WHERE id=?"
        );
        $stmt->bind_param(
            "ssssi", $name, $date_formed, $best_hit_album, $genre, $id
        );
        $stmt->execute();
        $stmt->close();
    }
    header('Location: index.php');
    exit();
}
?>
