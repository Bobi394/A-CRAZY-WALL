<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bilder_grid";

// Verbindung zur Datenbank
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$sql = "SELECT feldnummer, bildpfad FROM bilder";
$result = $conn->query($sql);

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[$row["feldnummer"]] = $row["bildpfad"];
}

echo json_encode($images);

$conn->close();
?>