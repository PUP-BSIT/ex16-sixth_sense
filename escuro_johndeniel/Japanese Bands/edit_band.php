<?php
require 'db.php';

$edit_band = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $result = $mysqli->query(
        "SELECT * FROM japanese_bands WHERE id=$edit_id"
    );
    $edit_band = $result->fetch_assoc();
}
?>
