<?php

include("config.php");

// Create connection
try {
    $conn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$sql = "SELECT Name FROM BoltonPlayers WHERE Club LIKE ? AND jsfm LIKE ?";
$stmt = $conn->prepare($sql);

$stmt->execute(["$_POST[clubname]%", "%$_POST[jsfm]"]);

echo json_encode($stmt->fetchAll(PDO::FETCH_COLUMN));
?>
