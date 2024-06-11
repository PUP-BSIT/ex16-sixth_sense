<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$team_name = $data['team_name'];
$championship = $data['championship'];
$Conference = $data['Conference'];
$player_name = $data['player_name'];
$city = $data['city'];

$sql = "UPDATE nba SET team_name = ?, championship = ?, Conference = ?, player_name = ?, city = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$team_name, $championship, $Conference, $player_name, $city, $id]);

echo json_encode(['message' => 'Team updated successfully']);
?>
