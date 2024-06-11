<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? null;
    $date_formed = $_POST['date_formed'] ?? null;
    $best_hit_album = $_POST['best_hit_album'] ?? null;
    $genre = $_POST['genre'] ?? null;
    
    if ($name && $date_formed && $best_hit_album && $genre) {
        $stmt = $mysqli->prepare(
            "INSERT INTO japanese_bands 
            (name, date_formed, best_hit_album, genre) 
            VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $date_formed, $best_hit_album, $genre);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: index.php');
    exit();
}
?>
