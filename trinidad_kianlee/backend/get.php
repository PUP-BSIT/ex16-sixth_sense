<?php

function getMovies($servername, $username, $password, $dbname) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if (!$connect) {
        die(json_encode(["error" => "Connection failed: " . mysqli_connect_error()]));
    }
    
    $sql = "SELECT * FROM movie ORDER BY id DESC";
    $result = $connect->query($sql);

    if (!$result) {
        echo json_encode(["error" => "Error fetching movies: " . mysqli_error($connect)]);
    } else {
        $movies = [];
        while ($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
        echo json_encode($movies);
    }
    mysqli_close($connect);
}
?>

