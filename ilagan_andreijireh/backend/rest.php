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
$dbname = "opm_artists";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    insertArtist($servername, $username, $password, $dbname, $data);
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    getArtists($servername, $username, $password, $dbname);
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    deleteArtist($servername, $username, $password, $dbname, $data['id']);
} elseif ($_SERVER["REQUEST_METHOD"] == "PATCH") {
    $data = json_decode(file_get_contents("php://input"), true);
    updateArtist($servername, $username, $password, $dbname, $data);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
}

function getArtists($servername, $username, $password, $dbname) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if (!$connect) {
        die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
    }

    $sql = "SELECT * FROM artists ORDER BY id DESC";
    $result = $connect->query($sql);

    if (!$result) {
        echo json_encode(["error" => "Error fetching artists: " . mysqli_error($connect)]);
    } else {
        $artists = [];
        while ($row = $result->fetch_assoc()) {
            $artists[] = $row;
        }
        echo json_encode($artists);
    }
    mysqli_close($connect);
}

function insertArtist($servername, $username, $password, $dbname, $data) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if (!$connect) {
        die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
    }

    $sql = "INSERT INTO artists (name, genre, albums, hits, debut) VALUES ('{$data['name']}', '{$data['genre']}', '{$data['albums']}', '{$data['hits']}', '{$data['debut']}')";

    if (!$connect->query($sql)) {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . mysqli_error($connect)]);
    } else {
        echo json_encode(["message" => "Artist added successfully"]);
    }
    mysqli_close($connect);
}

function deleteArtist($servername, $username, $password, $dbname, $id) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM artists WHERE id=$id";
    if (!$connect->query($sql)) {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . mysqli_error($connect)]);
    } else {
        echo json_encode(["message" => "Deleted successfully"]);
    }
    mysqli_close($connect);
}

function updateArtist($servername, $username, $password, $dbname, $data) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if (!$connect) {
        die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
    }

    $sql = "UPDATE artists SET name='{$data['name']}', genre='{$data['genre']}', albums='{$data['albums']}', hits='{$data['hits']}', debut='{$data['debut']}' WHERE id={$data['id']}";

    if (!$connect->query($sql)) {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . mysqli_error($connect)]);
    } else {
        echo json_encode(["message" => "Artist updated successfully"]);
    }
    mysqli_close($connect);
}