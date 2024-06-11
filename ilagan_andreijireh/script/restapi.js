document.addEventListener("DOMContentLoaded", function () {
    fetchArtists();
});

function fetchArtists() {
    fetch("./backend/rest.php")
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.error) {
                console.error("API Error:", data.error);
                return;
            }
            let tableBody = document.querySelector("#artist_table tbody");
            tableBody.innerHTML = "";
            data.forEach((artist) => {
                let row = `<tr>
                  <td>${artist.name}</td>
                  <td>${artist.genre}</td>
                  <td>${artist.albums}</td>
                  <td>${artist.hits}</td>
                  <td>${artist.debut}</td>
                  <td>
                      <button onclick="deleteArtist(${artist.id})">Delete</button>
                      <button onclick="editArtist(${artist.id}, 
                      '${artist.name}', 
                      '${artist.genre}', '${artist.albums}', 
                      '${artist.hits}', '${artist.debut}')">Edit</button>
                  </td>
              </tr>`;
                tableBody.innerHTML += row;
            });
        })
        .catch((error) => console.error("Error fetching artists:", error));
}

function insertArtist() {
    let name = document.getElementById("name").value;
    let genre = document.getElementById("genre").value;
    let albums = document.getElementById("albums").value;
    let hits = document.getElementById("hits").value;
    let debut = document.getElementById("debut").value;

    fetch("./backend/rest.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, genre, albums, hits, debut }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                alert(data.message || "Artist added successfully");
                fetchArtists();
                clearForm();
            }
        })
        .catch((error) => console.error("Error adding artist:", error));
}

function deleteArtist(id) {
    fetch("./backend/rest.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                alert(data.message);
                fetchArtists();
            }
        })
        .catch((error) => console.error("Error deleting artist:", error));
}

function editArtist(id, name, genre, albums, hits, debut) {
    document.getElementById("name").value = name;
    document.getElementById("genre").value = genre;
    document.getElementById("albums").value = albums;
    document.getElementById("hits").value = hits;
    document.getElementById("debut").value = debut;
    document.getElementById("artist_id").value = id;
    document.getElementById("add_btn").innerText = "Update Artist";
    document.getElementById("add_btn").onclick = function () {
        updateArtist(id);
    };
}

function updateArtist(id) {
    let name = document.getElementById("name").value;
    let genre = document.getElementById("genre").value;
    let albums = document.getElementById("albums").value;
    let hits = document.getElementById("hits").value;
    let debut = document.getElementById("debut").value;

    fetch("./backend/rest.php", {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, name, genre, albums, hits, debut }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                alert(data.message || "Artist updated successfully");
                fetchArtists();
                clearForm();
            }
        })
        .catch((error) => console.error("Error updating artist:", error));
}

function clearForm() {
    document.getElementById("name").value = "";
    document.getElementById("genre").value = "";
    document.getElementById("albums").value = "";
    document.getElementById("hits").value = "";
    document.getElementById("debut").value = "";
    document.getElementById("artist_id").value = "";
    document.getElementById("add_btn").innerText = "Add Artist";
    document.getElementById("add_btn").onclick = insertArtist;
}