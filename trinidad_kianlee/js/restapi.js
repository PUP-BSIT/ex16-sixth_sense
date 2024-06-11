document.addEventListener('DOMContentLoaded', function() {
  fetchMovies();
});

function fetchMovies() {
  fetch("https://memoirverse.site/api/rest.php")
      .then(response => response.json())
      .then(data => {
          let tbody = document.querySelector("#movie_table tbody");
          tbody.innerHTML = '';
          data.forEach(movie => {
              let row = document.createElement("tr");
              row.innerHTML = `
                  <td>${movie.movie_name}</td>
                  <td>${movie.cast}</td>
                  <td>${movie.release_date}</td>
                  <td>${movie.genre}</td>
                  <td>${movie.rating}</td>
                  <td>
                      <button onclick="editMovie(${movie.id}, 
                      '${movie.movie_name}', '${movie.cast}', 
                      '${movie.release_date}', '${movie.genre}', 
                      '${movie.rating}')">Edit</button>
                      <button onclick="deleteMovie(${movie.id})">Delete</button>
                  </td>
              `;
              tbody.appendChild(row);
          });
      })
      .catch(error => console.error('Error fetching movies:', error));
}

function insertMovie() {
  let movie_name = document.getElementById("movie_name").value;
  let cast = document.getElementById("cast").value;
  let release_date = document.getElementById("release_date").value;
  let genre = document.getElementById("genre").value;
  let rating = document.getElementById("rating").value;

  let data = { movie_name, cast, release_date, genre, rating };

  fetch("https://memoirverse.site/api/rest.php", {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded",
       },
      body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
      if (data.error) {
          alert("Error: " + data.error);
      } else {
          alert(data.message || "Movie added successfully");
          fetchMovies();
          clearForm();
      }
  })
  .catch(error => console.error("Error adding movie:", error));
}

function deleteMovie(id) {
  fetch("https://memoirverse.site/api/rest.php", {
      method: "DELETE",
      headers: {
        "Content-type": "application/x-www-form-urlencoded",
       },
      body: JSON.stringify({ id })
  })
  .then(response => response.json())
  .then(data => {
      if (data.error) {
          alert("Error: " + data.error);
      } else {
          alert(data.message);
          fetchMovies();
      }
  })
  .catch(error => console.error("Error deleting movie:", error));
}

function editMovie(id, movie_name, cast, release_date, genre, rating) {
  document.getElementById("movie_id").value = id;
  document.getElementById("movie_name").value = movie_name;
  document.getElementById("cast").value = cast;
  document.getElementById("release_date").value = release_date;
  document.getElementById("genre").value = genre;
  document.getElementById("rating").value = rating;
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

  let data = { id, movie_name, cast, release_date, genre, rating };

  fetch("https://memoirverse.site/api/rest.php", {
      method: "PATCH",
      headers: {
        "Content-type": "application/x-www-form-urlencoded",
       },
      body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
      if (data.error) {
          alert("Error: " + data.error);
      } else {
          alert(data.message || "Movie updated successfully");
          fetchMovies();
          clearForm();
      }
  })
  .catch(error => console.error("Error updating movie:", error));
}

function clearForm() {
  document.getElementById("movie_id").value = '';
  document.getElementById("movie_name").value = '';
  document.getElementById("cast").value = '';
  document.getElementById("release_date").value = '';
  document.getElementById("genre").value = '';
  document.getElementById("rating").value = '';
  document.getElementById("add_btn").innerText = "Add Movie";
  document.getElementById("add_btn").onclick = insertMovie;
}
