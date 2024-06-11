<?php

require 'db_connect.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$method = $_SERVER['REQUEST_METHOD'];

$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT * FROM volleyball WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM volleyball");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($result);
        break;

    case 'POST':
        $sql = "INSERT INTO volleyball (v_team, v_coach, 
            v_players, position, championship) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $input['v_team'], 
            $input['v_coach'], 
            $input['v_players'], 
            $input['position'], 
            $input['championship']
        ]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
        break;

    case 'PUT':
        $id = $_GET['id'];
        $sql = "UPDATE volleyball SET v_team = ?, v_coach = ?, 
            v_players = ?, position = ?, championship = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $input['v_team'], 
            $input['v_coach'], 
            $input['v_players'], 
            $input['position'], 
            $input['championship'], 
            $id
        ]);
        echo json_encode(['message' => 'Record updated']);
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $sql = "DELETE FROM volleyball WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo json_encode(['message' => 'Record deleted']);
        break;

    default:
        echo json_encode(['message' => 'Method not supported']);
        break;
}
?>