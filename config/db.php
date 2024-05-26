<?php
$host = 'localhost';
$db = 'learning';
$user = 'root';
$pass = 'root';

$con = "mysql:host=$host;dbname=$db;charset=utf8";

try {
    $pdo = new PDO($con, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
