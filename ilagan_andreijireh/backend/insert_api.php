<?php
function insertArtist($servername, $username, $password, $dbname, $data) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $data['name'];
    $genre = $data['genre'];
    $albums = $data['albums'];
    $hits = $data['hits'];
    $debut = $data['debut'];

    $sql = "INSERT INTO artists (name, genre, albums, hits, debut) VALUES ('$name', '$genre', '$albums', '$hits', '$debut')";

    if ($conn->query($sql) === TRUE) {
        $artist = array(
            "id" => $conn->insert_id,
            "name" => $name,
            "genre" => $genre,
            "albums" => $albums,
            "hits" => $hits,
            "debut" => $debut
        );

        echo json_encode(array("message" => "Artist added successfully", "artist" => $artist));
    } else {
        echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
    }

    $conn->close();
}
?>