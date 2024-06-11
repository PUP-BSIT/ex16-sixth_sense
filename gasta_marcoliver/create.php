<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$team_name = $data['team_name'];
$championship = $data['championship'];
$Conference = $data['Conference'];
$player_name = $data['player_name'];
$city = $data['city'];

$sql = "INSERT INTO teams (team_name, championship, Conference, player_name, city) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$team_name, $championship, $Conference, $player_name, $city]);

echo json_encode(['message' => 'Team created successfully']);
?>
