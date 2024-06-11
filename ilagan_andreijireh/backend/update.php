<?php
function updateArtist($servername, $username, $password, $dbname, $data) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $data['id'];
    $name = $data['name'];
    $genre = $data['genre'];
    $albums = $data['albums'];
    $hits = $data['hits'];
    $debut = $data['debut'];

    $sql = "UPDATE artists SET name='$name', genre='$genre', albums='$albums', hits='$hits', debut='$debut' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $artist = array(
            "id" => $id,
            "name" => $name,
            "genre" => $genre,
            "albums" => $albums,
            "hits" => $hits,
            "debut" => $debut
        );

        echo json_encode(array("message" => "Artist updated successfully", "artist" => $artist));
    } else {
        echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
    }

    $conn->close();
}
?>