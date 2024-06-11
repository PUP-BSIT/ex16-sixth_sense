<?php
require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGet($mysqli);
        break;
    case 'POST':
        handlePost($mysqli);
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        handlePut($mysqli, $_PUT);
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        handleDelete($mysqli, $_DELETE);
        break;
    default:
        echo 'Invalid request method';
        break;
}
