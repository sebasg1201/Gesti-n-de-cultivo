<?php

$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'cultivos';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "ALTER TABLE terreno MODIFY area_m2 DECIMAL(15,2) NULL";

if (mysqli_query($conn, $sql)) {
    echo "Table 'terreno' updated successfully.\n";
} else {
    echo "Error updating table: " . mysqli_error($conn) . "\n";
}

mysqli_close($conn);
