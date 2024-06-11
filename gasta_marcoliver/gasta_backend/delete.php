<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];

$sql = "DELETE FROM nba WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

echo json_encode(['message' => 'Team deleted successfully']);
?>
