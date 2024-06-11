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

function handleGet($mysqli) {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $result = $mysqli->query("SELECT * FROM japanese_bands WHERE id=$id");
        if ($result) {
            $data = $result->fetch_assoc();
            if ($data) {
                echo "Band ID: " . $data['id'] . "<br>";
                echo "Name: " . $data['name'] . "<br>";
                echo "Date Formed: " . $data['date_formed'] . "<br>";
                echo "Best Hit Album: " . $data['best_hit_album'] . "<br>";
                echo "Genre: " . $data['genre'] . "<br>";
            } else {
                echo "No band found with ID: $id";
            }
        } else {
            echo "Error executing query: " . $mysqli->error;
        }
    } else {
        $result = $mysqli->query("SELECT * FROM japanese_bands");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo "Band ID: " . $row['id'] . "<br>";
                echo "Name: " . $row['name'] . "<br>";
                echo "Date Formed: " . $row['date_formed'] . "<br>";
                echo "Best Hit Album: " . $row['best_hit_album'] . "<br>";
                echo "Genre: " . $row['genre'] . "<br>";
                echo "<hr>";
            }
        } else {
            echo "Error executing query: " . $mysqli->error;
        }
    }
}

function handlePost($mysqli) {
    $name = $_POST['name'] ?? null;
    $date_formed = $_POST['date_formed'] ?? null;
    $best_hit_album = $_POST['best_hit_album'] ?? null;
    $genre = $_POST['genre'] ?? null;

    if ($name && $date_formed && $best_hit_album && $genre) {
        $stmt = $mysqli->prepare(
            "INSERT INTO japanese_bands (name, date_formed, best_hit_album, genre) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $date_formed, $best_hit_album, $genre);
        if ($stmt->execute()) {
            echo "Band created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

function handlePut($mysqli, $input) {
    $id = $input['id'] ?? null;
    $name = $input['name'] ?? null;
    $date_formed = $input['date_formed'] ?? null;
    $best_hit_album = $input['best_hit_album'] ?? null;
    $genre = $input['genre'] ?? null;

    if ($id && $name && $date_formed && $best_hit_album && $genre) {
        $stmt = $mysqli->prepare(
            "UPDATE japanese_bands SET name=?, date_formed=?, best_hit_album=?, genre=? WHERE id=?"
        );
        $stmt->bind_param("ssssi", $name, $date_formed, $best_hit_album, $genre, $id);
        if ($stmt->execute()) {
            echo "Band updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

function handleDelete($mysqli, $input) {
    $id = $input['id'] ?? null;

    if ($id) {
        $stmt = $mysqli->prepare("DELETE FROM japanese_bands WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Band deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "ID is required.";
    }
}
?>