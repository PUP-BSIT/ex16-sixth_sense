<?php
function deleteArtist($servername, $username, $password, $dbname, $id) {
    $connect = mysqli_connect($servername, $username, $password, $dbname);
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM artists WHERE id = $id";

    if (mysqli_query($connect, $sql)) {
        echo json_encode(["message" => "Artist deleted successfully"]);
    } else {
        echo json_encode(["error" => "Error deleting artist: " . mysqli_error($connect)]);
    }

    mysqli_close($connect);
}
?>