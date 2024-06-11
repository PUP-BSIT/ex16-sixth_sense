<?php
require 'db.php';

$sql = "SELECT * FROM nba";
$stmt = $pdo->query($sql);

$teams = $stmt->fetchAll();

echo json_encode($teams);
?>
