<?php
$servername = "localhost";
$username = "root";  // Falls du XAMPP oder WAMP nutzt
$password = "";
$dbname = "bilder_grid";

// Verbindung zur Datenbank
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Prüfen, ob ein Bild hochgeladen wurde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $feldnummer = intval($_POST["feldnummer"]);
    $uploadDir = "uploads/";

    // Verzeichnis erstellen, falls es nicht existiert
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES["image"]["name"]);
    $filePath = $uploadDir . uniqid() . "_" . $fileName;

    // Bild speichern
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $filePath)) {
        // Bild in die Datenbank eintragen (falls Feld schon belegt, aktualisieren)
        $stmt = $conn->prepare("INSERT INTO bilder (feldnummer, bildpfad) VALUES (?, ?) ON DUPLICATE KEY UPDATE bildpfad = VALUES(bildpfad)");
        $stmt->bind_param("is", $feldnummer, $filePath);
        $stmt->execute();
        echo json_encode(["success" => true, "imagePath" => $filePath]);
    } else {
        echo json_encode(["success" => false, "error" => "Fehler beim Hochladen"]);
    }
}

$conn->close();
?>