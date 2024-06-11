<?php
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data !== null) {
    $team_name = isset($data['team_name']) ? $data['team_name'] : '';
    $championship = isset($data['championship']) ? $data['championship'] : '';
    $Conference = isset($data['Conference']) ? $data['Conference'] : '';
    $player_name = isset($data['player_name']) ? $data['player_name'] : '';
    $city = isset($data['city']) ? $data['city'] : '';

    $sql = "INSERT INTO nba (team_name, championship, Conference, player_name, city) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$team_name, $championship, $Conference, $player_name, $city]);

    echo json_encode(['message' => 'Team created successfully']);
} else {
    echo json_encode(['error' => 'Invalid data']);
}
?>