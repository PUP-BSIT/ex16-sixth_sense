<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

header("Content-Type: application/json");

include 'insert_api.php';
include 'update.php';
include 'delete.php';
include 'get.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movies";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    insertMovie($servername, $username, $password, $dbname, $data);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    getMovies($servername, $username, $password, $dbname);
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    deleteMovie($servername, $username, $password, $dbname, $data['id']);
} elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    $data = json_decode(file_get_contents("php://input"), true);
    updateMovie($servername, $username, $password, $dbname, $data);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
}
?>
