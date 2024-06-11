<?php
require 'db.php';
require 'edit_band.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Japanese Bands</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Japanese Bands</h1>
        <form action="<?php echo isset($edit_band) ? 
            'update_band.php' : 'create_band.php'; ?>" method="post">
            <input type="hidden" name="id" 
                value="<?php echo $edit_band['id'] ?? ''; ?>">
            <input type="text" name="name" placeholder="Name of Band" 
                value="<?php echo $edit_band['name'] ?? ''; ?>" required>
            <input type="date" name="date_formed" placeholder="Date Formed" 
                value="<?php echo $edit_band['date_formed'] ?? ''; ?>" required>
            <input type="text" name="best_hit_album" 
                placeholder="Best Hit Album" 
                value="<?php echo $edit_band['best_hit_album'] ?? ''; ?>" required>
            <input type="text" name="genre" placeholder="Genre" 
                value="<?php echo $edit_band['genre'] ?? ''; ?>" required>
            <button type="submit">
                <?php echo isset($edit_band) ? 'Update Band' : 'Add Band'; ?>
            </button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date Formed</th>
                    <th>Best Hit Album</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $mysqli->query("SELECT * FROM japanese_bands");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['date_formed'] . "</td>";
                    echo "<td>" . $row['best_hit_album'] . "</td>";
                    echo "<td>" . $row['genre'] . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<a href='index.php?edit=" . $row['id'] . 
                        "' class='edit'>Edit</a>";
                    echo "<form action='delete_band.php' method='post' 
                            style='display:inline;'>
                            <input type='hidden' name='id' 
                                value='" . $row['id'] . "'>
                            <button type='submit'>Delete</button>
                          </form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
$mysqli->close();
?>
