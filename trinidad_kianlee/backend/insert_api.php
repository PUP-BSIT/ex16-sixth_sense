<?php
require_once("rest.php");
function insertMovie($servername, $username, $password, $dbname, $data) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);

    if (!$connect) {
        die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
    }

    $sql = "INSERT INTO movies (movie_name, cast, release_date, genre, rating) VALUES ('{$data['movie_name']}', '{$data['cast']}', '{$data['release_date']}', '{$data['genre']}', '{$data['rating']}')";

    if (!$connect->query($sql)) {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . mysqli_error($connect)]);
    } else {
        echo json_encode(["message" => "Movie added successfully"]);
    }
    mysqli_close($connect);
}
?>
