<?php
require_once("rest.php");
function updateMovie($servername, $username, $password, $dbname, $data) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);

    if (!$connect) {
        die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
    }

    $sql = "UPDATE movies SET movie_name='{$data['movie_name']}', cast='{$data['cast']}', release_date='{$data['release_date']}', genre='{$data['genre']}', rating='{$data['rating']}' WHERE id={$data['id']}";

    if (!$connect->query($sql)) {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . mysqli_error($connect)]);
    } else {
        echo json_encode(["message" => "Movie updated successfully"]);
    }
    mysqli_close($connect);
}
?>
