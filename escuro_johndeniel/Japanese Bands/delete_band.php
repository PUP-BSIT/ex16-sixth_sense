<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    
    if ($id) {
        $stmt = $mysqli->prepare(
            "DELETE FROM japanese_bands WHERE id=?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: index.php');
    exit();
}
?>
