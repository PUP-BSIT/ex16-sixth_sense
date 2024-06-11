<?php
function getArtists($servername, $username, $password, $dbname) {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, name, genre, albums, hits, debut FROM artists";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $artists = array();

        while($row = $result->fetch_assoc()) {
            $artist = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "genre" => $row["genre"],
                "albums" => $row["albums"],
                "hits" => $row["hits"],
                "debut" => $row["debut"]
            );

            $artists[] = $artist;
        }

        echo json_encode($artists);
    } else {
        echo json_encode(array("message" => "No artists found."));
    }

    $conn->close();
}
?>