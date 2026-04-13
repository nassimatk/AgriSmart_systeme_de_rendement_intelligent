<?php
session_start(); // On démarre la session ici globalement

$host = "localhost";
$user = "root";
$pass = "";
$db = "agrismart";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué: " . $conn->connect_error);
}
?>
