<?php
$host       = 'localhost';
$dbname     = 'piranti';
$username   = 'root';
$password   = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch time
    $timeData = [];
    $stmt = $conn->query('SELECT time FROM uas');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $timeData[] = $row['time'];
    }

    // Fetch temperature data
    $temperatureData = [];
    $stmt = $conn->query('SELECT temperature FROM uas');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $temperatureData[] = $row['temperature'];
    }

    // Fetch humidity data
    $humidityData = [];
    $stmt = $conn->query('SELECT humidity FROM uas');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $humidityData[] = $row['humidity'];
    }

    // Fetch status_temperature data
    $statusTemperatureData = [];
    $stmt = $conn->query('SELECT status_temperature FROM uas');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $statusTemperatureData[] = $row['status_temperature'];
    }

    // Fetch status_humidity data
    $statusHumidityData = [];
    $stmt = $conn->query('SELECT status_humidity FROM uas');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $statusHumidityData[] = $row['status_humidity'];
    }
    } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    die();
}

$conn = null;
?>
