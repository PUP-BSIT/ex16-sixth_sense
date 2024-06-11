<?php
$servername = "127.0.0.1:3306";
$username = "u586757316_sixth_senses";
$password = "*N5E!z!xo#Z6";
$dbname = "u586757316_sixth_sense";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$method = $_SERVER['REQUEST_METHOD'];

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

$id = isset($request[0]) ? intval($request[0]) : null;

function getInputData() {
    return json_decode(file_get_contents('php://input'), true);
}

switch ($method) {
    case 'GET':
        if ($id) {
            $sql = "SELECT * FROM artists WHERE id = $id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo json_encode($result->fetch_assoc());
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Artist not found"]);
            }
        } else {
            $sql = "SELECT * FROM artists";
            $result = $conn->query($sql);
            $artists = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $artists[] = $row;
                }
                echo json_encode($artists);
            } else {
                echo json_encode([]);
            }
        }
        break;

    case 'POST':
        $data = getInputData();
        $name = $data['artist_name'];
        $genre = $data['artist_genre'];
        $albums = $data['artist_albums'];
        $hits = $data['artist_hits'];
        $debut = $data['artist_debut'];

        $sql = "INSERT INTO artists (name, genre, albums, hits, debut) 
        VALUES ('$name', '$genre', $albums, '$hits', $debut)";
        if ($conn->query($sql) === TRUE) {
            http_response_code(201);
            echo json_encode(["message" => "Artist created successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error creating artist: " . $conn->error]);
        }
        break;

    case 'PATCH':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["message" => "Artist ID is required"]);
            break;
        }

        $data = getInputData();
        $name = $data['name'];
        $genre = $data['genre'];
        $albums = $data['albums'];
        $hits = $data['hits'];
        $debut = $data['debut'];

        $sql = "UPDATE artists SET name='$name', genre='$genre', 
        albums=$albums, hits='$hits', debut=$debut WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Artist updated successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error updating artist: " . $conn->error]);
        }
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["message" => "Artist ID is required"]);
            break;
        }

        $sql = "DELETE FROM artists WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Artist deleted successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error deleting artist: " . $conn->error]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

$conn->close();
?>
