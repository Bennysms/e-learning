<?php
session_start();
if ($_SESSION['auth']) {
    $photo = $_SESSION['user']['photo'];
    $nom = $_SESSION['user']['nom'];
    $prenom = $_SESSION['user']['prenom'];
    $role = $_SESSION['user']['role'];
    $id_users = $_SESSION['user']['id_user'];
} else {
    header('Location:login.php');
}
?>
<nav class="sidebar">
    <header>
        <img src=<?php echo 'media/' . $photo ?> />
        <div>
            <h2><?php echo $nom . ' ' . $prenom ?> </h2>
            <p><?php echo $role ?> </p>
        </div>
    </header>
    <ul>
        <?php
        if ($_SESSION['user']['role'] === 'Formateur') {
            echo '<li><a href="formations.php">Formations</a></li>
        <li><a href="participants.php">Participants</a></li>
        <li><a href="projets.php">Projets réalisés</a></li>
        <li><a href="mesfichiers.php">Mes Fichiers</a></li>';
        } else {
            echo '<li><a href="mesformations.php">Mes formations</a></li>
        <li><a href="demande.php">Demander</a></li>';
        }

        ?>


    </ul>
    <a href="logout.php" id="logout">Déconnexion</a>
</nav>