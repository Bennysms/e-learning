<?php
include './config/db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // requete pour modifier les données dans la base de données
    try {
        $stmt = $pdo->prepare("UPDATE  Participants SET statut='Accepté' WHERE id_participant = $id");
        $stmt->execute([$id]);
        header('Location:participants.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
