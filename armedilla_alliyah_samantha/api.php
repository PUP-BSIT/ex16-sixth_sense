<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header('Content-Type: application/json');

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM groups WHERE id = $id";
            $result = $conn->query($sql);
            if ($result) {
                echo json_encode($result->fetch_assoc());
            } else {
                echo json_encode(["error" => $conn->error]);
            }
        } else {
            $sql = "SELECT * FROM groups";
            $result = $conn->query($sql);
            if ($result) {
                $groups = array();
                while($row = $result->fetch_assoc()) {
                    $groups[] = $row;
                }
                echo json_encode($groups);
            } else {
                echo json_encode(["error" => $conn->error]);
            }
        }
        break;

    case 'POST':
        $group_name = $_POST['group_name'];
        $number_of_members = intval($_POST['number_of_members']);
        $Leader = $_POST['Leader'];
        $song = $_POST['song'];
        $company_name = $_POST['company_name'];
        $sql = "INSERT INTO groups (group_name, number_of_members, Leader, song, company_name) VALUES ('$group_name', $number_of_members, '$Leader', '$song', '$company_name')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["id" => $conn->insert_id]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        $id = intval($_GET['id']);
        $group_name = $_PUT['group_name'];
        $number_of_members = intval($_PUT['number_of_members']);
        $Leader = $_PUT['Leader'];
        $song = $_PUT['song'];
        $company_name = $_PUT['company_name'];
        $sql = "UPDATE groups SET group_name='$group_name', number_of_members=$number_of_members, Leader='$Leader', song='$song', company_name='$company_name' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["id" => $id]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    case 'DELETE':
        $id = intval($_GET['id']);
        $sql = "DELETE FROM groups WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["id" => $id]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request method"]);
        break;
}

$conn->close();
?>