fetch('https://your-hostinger-server.com/api.php', {
    method: 'GET',

})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));

const mysql = require('mysql2/promise');

async function handlePost(input) {
    const name = input.name;
    const date_formed = input.date_formed;
    const best_hit_album = input.best_hit_album;
    const genre = input.genre;

    if (name && date_formed && best_hit_album && genre) {
        try {
            const connection = await mysql.createConnection({
                host: 'your_hostinger_database_host',
                user: 'your_username',
                password: 'your_password',
                database: 'your_database_name'
            });

            const [rows] = await connection.execute(
                "INSERT INTO japanese_bands (name, date_formed, best_hit_album, genre) VALUES (?, ?, ?, ?)",
                [name, date_formed, best_hit_album, genre]
            );

            console.log("Band created successfully.");
            await connection.end();
        } catch (error) {
            console.error("Error: ", error);
        }
    } else {
        console.log("All fields are required.");
    }
}

async function handlePut(input) {
    const id = input.id;
    const name = input.name;
    const date_formed = input.date_formed;
    const best_hit_album = input.best_hit_album;
    const genre = input.genre;

    if (id && name && date_formed && best_hit_album && genre) {
        try {
            const connection = await mysql.createConnection({
                host: 'your_hostinger_database_host',
                user: 'your_username',
                password: 'your_password',
                database: 'your_database_name'
            });

            const [rows] = await connection.execute(
                "UPDATE japanese_bands SET name=?, date_formed=?, best_hit_album=?, genre=? WHERE id=?",
                [name, date_formed, best_hit_album, genre, id]
            );

            console.log("Band updated successfully.");
            await connection.end();
        } catch (error) {
            console.error("Error: ", error);
        }
    } else {
        console.log("All fields are required.");
    }
}