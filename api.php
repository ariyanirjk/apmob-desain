<?php
header("Content-Type: application/json");

// Database configuration
$dbHost = "localhost"; // sesuaikan konfigurasi server anda
$dbName = "data_desain";
$dbUser = "root"; // sesuaikan konfigurasi server anda
$dbPassword = ""; // sesuaikan konfigurasi server anda


// Create a MySQLi connection
$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get Todo list
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $result = $mysqli->query("SELECT * FROM desain");
    $desain = [];
    
    while ($row = $result->fetch_assoc()) {
        $desain[] = $row;
    }

    echo json_encode($desain);
}

// Add new Todo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["nama"]) && isset($data["nim"]) && isset($data["jenis_kelamin"]) && isset($data["karya_desain"])) {
        $nama = $data["nama"];
        $nim = $data["nim"];
        $jenis_kelamin = $data["jenis_kelamin"];
        $karya_desain = $data["karya_desain"];

        $mysqli->query("INSERT INTO desain (nama, nim, jenis_kelamin, karya_desain) VALUES ('$nama', '$nim', '$jenis_kelamin', '$karya_desain')");
        echo json_encode(["message" => "Data added successfully"]);
    } else {
        echo json_encode(["error" => "data are required"]);
    }
}

// Close the MySQLi connection
$mysqli->close();
?>