<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'insert_api.php';
include 'update.php';
include 'delete.php';
include 'get.php';


$method = $_SERVER['REQUEST_METHOD'];

$servername = "127.0.0.1:3306";
$username = "u586757316_sixth_senses";
$password = "*N5E!z!xo#Z6";
$dbname = "u586757316_sixth_sense";

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
