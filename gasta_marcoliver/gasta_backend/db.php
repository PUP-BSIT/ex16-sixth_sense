<?php
$servername = "127.0.0.1:3306";
$username = "u586757316_sixth_senses";
$password = "*N5E!z!xo#Z6";
$dbname = "u586757316_sixth_sense";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>