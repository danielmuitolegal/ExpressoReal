<?php

require_once('../../bdd/database.php');

$sql = "SELECT * FROM sensores";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sensores = $stmt->fetch_All(MYSQLI_ASSOC);
$conn = null;
?>