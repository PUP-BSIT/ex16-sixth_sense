document.addEventListener("DOMContentLoaded", function () {
  fetchMovies();
});

function fetchMovies() {
  fetch("https://memoirverse.site/api/rest.php")
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
      let tableBody = document.querySelector("#movie_table tbody");
      tableBody.innerHTML = "";
      data.forEach((movie) => {
        let row = `<tr>
                <td>${movie.movie_name}</td>
                <td>${movie.cast}</td>
                <td>${movie.release_date}</td>
                <td>${movie.genre}</td>
                <td>${movie.rating}</td>
                <td>
                    <button onclick="deleteMovie(${movie.id})">Delete</button>
                    <button onclick="editMovie(${movie.id}, 
                    '${movie.movie_name}', '${movie.cast}', 
                    '${movie.release_date}', '${movie.genre}', 
                    '${movie.rating}')">Edit</button>
                </td>
            </tr>`;
        tableBody.innerHTML += row;
      });
    })
    .catch((error) => console.error("Error fetching movies:", error));
}

function insertMovie() {
  let movie_name = document.getElementById("movie_name").value;
  let cast = document.getElementById("cast").value;
  let release_date = document.getElementById("release_date").value;
  let genre = document.getElementById("genre").value;
  let rating = document.getElementById("rating").value;

  fetch("https://memoirverse.site/api/rest.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ movie_name, cast, release_date, genre, rating }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        alert("Error: " + data.error);
      } else {
        alert(data.message || "Movie added successfully");
        fetchMovies();
        clearForm();
      }
    })
    .catch((error) => console.error("Error adding movie:", error));
}

function deleteMovie(id) {
  fetch("https://memoirverse.site/api/rest.php", {
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
        fetchMovies();
      }
    })
    .catch((error) => console.error("Error deleting movie:", error));
}

function editMovie(id, movie_name, cast, release_date, genre, rating) {
  document.getElementById("movie_name").value = movie_name;
  document.getElementById("cast").value = cast;
  document.getElementById("release_date").value = release_date;
  document.getElementById("genre").value = genre;
  document.getElementById("rating").value = rating;
  document.getElementById("movie_id").value = id;
  document.getElementById("add_btn").innerText = "Update Movie";
  document.getElementById("add_btn").onclick = function () {
    updateMovie(id);
  };
}

function updateMovie(id) {
  let movie_name = document.getElementById("movie_name").value;
  let cast = document.getElementById("cast").value;
  let release_date = document.getElementById("release_date").value;
  let genre = document.getElementById("genre").value;
  let rating = document.getElementById("rating").value;

  fetch("https://memoirverse.site/api/rest.php", {
    method: "PATCH",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, movie_name, cast, release_date, genre, rating }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        alert("Error: " + data.error);
      } else {
        alert(data.message || "Movie updated successfully");
        fetchMovies();
        clearForm();
      }
    })
    .catch((error) => console.error("Error updating movie:", error));
}

function clearForm() {
  document.getElementById("movie_name").value = "";
  document.getElementById("cast").value = "";
  document.getElementById("release_date").value = "";
  document.getElementById("genre").value = "";
  document.getElementById("rating").value = "";
  document.getElementById("movie_id").value = "";
  document.getElementById("add_btn").innerText = "Add Movie";
  document.getElementById("add_btn").onclick = insertMovie;
}
