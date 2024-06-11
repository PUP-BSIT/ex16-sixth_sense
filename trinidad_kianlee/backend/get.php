<?php
require_once("rest.php");
function getMovies($servername, $username, $password, $dbname) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);

    if (!$connect) {
        die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
    }

    $sql = "SELECT * FROM movies";
    $result = $connect->query($sql);

    $movies = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
    }

    echo json_encode($movies);
    mysqli_close($connect);
}
?>
