<?php
$host       = "localhost";
$username   = "root";
$password   = "";
$database   = "piranti";

$conn = mysqli_connect($host, $username, $password, $database);

// Mengecek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mendapatkan nilai dari sensor
$temperature        = $_POST["temperature"];
$humidity           = $_POST["humidity"];
$statusTemperature  = $_POST["status_temperature"];
$statusHumidity     = $_POST["status_humidity"];

// Memasukkan nilai ke dalam database
$sql = "INSERT INTO uas (temperature, humidity, status_temperature, status_humidity) VALUES ('$temperature', '$humidity', '$statusTemperature', '$statusHumidity')";

if (mysqli_query($conn, $sql)) {
    echo "Data berhasil disimpan";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Menutup koneksi
mysqli_close($conn);
?>
