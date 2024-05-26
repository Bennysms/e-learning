<?php
session_start();
include './config/db.php';
if (isset($_GET['id'])) {
  $id_formation = $_GET['id'];
  try {
    $stmt1 = $pdo->prepare("SELECT Formations.*, Users.photo,Users.nom,Users.prenom FROM Formations JOIN Users ON Formations.formateur_id = Users.id_user WHERE id_formation = ?");
    $stmt1->execute([$id_formation]);
    if ($stmt1->rowCount() > 0) {
      $video = $stmt1->fetch(PDO::FETCH_ASSOC);
      // avoir la bonne date
      $date = date("d-m-Y", strtotime($video['date_ajout']));
    } else {
      echo 'Vidéo introuvable';
      exit();
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
} else {
  echo 'Identifiant de la vidéos introuvable';
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Watch Courses</title>
  <link rel="stylesheet" href="./style/compte.css">
  <link rel="stylesheet" href="./style/watch.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <main>
    <!-- inclure la side bar -->
    <?php
    include 'sidebar.php';
    ?>
    <!-- main container -->
    <div class="main">
      <div class="videoContent">
        <div class="video">
          <video src=<?php echo 'videos/' . $video['video'] ?> autoplay controls></video>
        </div>
        <div class="videoText">
          <h2><?php echo $video['titre'] ?></h2>
          <div class="user">
            <img src=<?php echo 'media/' . $video['photo'] ?> alt="">
            <div>
              <h3><?php echo $video['nom'] . ' ' . $video['prenom'] ?></h3>
              <p>Publié : <?php echo $date ?></p>
            </div>
          </div>
        </div>
        <!-- ajouter commentaires -->
        <?php
        // Vérifie si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
          $commentaire = $_POST['commentaire'];
          try {

            // Insérer dans la table un Utilisateur
            $stmt4 = $pdo->prepare("INSERT INTO Comments (id_formation, id_user, commentaire) VALUES (?, ?, ?)");
            $stmt4->execute([$id_formation, $id_users, $commentaire]);
            $succes = 'Compte crée avec succès';
            // Traitement des données du formulaire ici
            // Assure-toi d'utiliser les données postées de manière sécurisée
            // par exemple, en utilisant des requêtes préparées pour les requêtes SQL
            // Redirige ensuite l'utilisateur vers la même page pour préserver l'ID
            $stmt5 = $pdo->prepare("SELECT c.*, u.photo, u.nom, u.prenom FROM Comments c JOIN Users u ON c.id_user = u.id_user WHERE c.id_formation = ?");
            $stmt5->execute([$id_formation]);
            $comments = $stmt5->fetch((PDO::FETCH_ASSOC));

            header("Location: {$_SERVER['REQUEST_URI']}");
            exit();
          } catch (PDOException $e) {
            echo $e->getMessage();
          }
        }

        ?>

        <!-- ********************* -->
        <!--recuperer les commentaires commentaires -->
        <?php
        try {
          $stmt5 = $pdo->prepare("SELECT c.*, u.photo, u.nom, u.prenom FROM Comments c JOIN Users u ON c.id_user = u.id_user WHERE c.id_formation = ? ORDER BY id_comment DESC");
          $stmt5->execute([$id_formation]);
          $comments = $stmt5->fetchAll((PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
        ?>
        <div class="comments">

          <p class="nbr"><span><?php echo count($comments) ?></span><?php if (count($comments) > 1) {
                                                                      echo 'Commentaires';
                                                                    } else {
                                                                      echo 'Commentaire';
                                                                    } ?></p>
          <div class="comments-aut">
            <img src=<?php echo 'media/' . $photo ?> alt="">
            <!-- formulaire -->
            <form class="comments-content" method="POST">
              <textarea placeholder="Ajoutez un commentaire" required name="commentaire"></textarea>
              <div class="boutons">
                <button class="btn1" type="reset">Annuler</button>
                <button class="btn2" type="submit" name="comment">Ajouter un commentaire</button>
              </div>
            </form>

          </div>

          <div class="comments-container">
            <!-- tous les commantaires -->
            <?php
            if (count($comments) > 0) {
            ?>
              <?php foreach ($comments as $comment) : ?>
                <div class="comment">
                  <img src=<?php echo 'media/' . $comment['photo'] ?> alt="">
                  <div class="comment-text">
                    <div>
                      <h3><?php echo $comment['nom'] . ' ' . $comment['prenom'] ?> </h3> <span>Date de publication : <?php $date = date("d-m-Y", strtotime($comment['date_commentaire']));
                                                                                                                      $heure = date("H:i", strtotime($comment['date_commentaire']));
                                                                                                                      echo $date . " " . $heure;                                                                                          ?></span>
                    </div>
                    <p><?php echo $comment['commentaire'] ?></p>
                  </div>
                </div>
              <?php endforeach ?>

            <?php } else {
              echo 'Aucun commentaire pour le moment';
            }
            ?>

          </div>
        </div>
      </div>
      <!-- videos categorie -->
      <div class="videoCategorie">
        <?php
        try {
          $stmt2 = $pdo->prepare("SELECT f.video, f.titre,f.date_ajout, f.id_formation, u.nom, u.prenom, c.nom AS nom_categorie FROM Formations f JOIN Users u ON f.formateur_id = u.id_user JOIN Categories c ON f.id_categorie = c.id_categorie WHERE f.id_categorie = ?");
          $stmt2->execute([$video['id_categorie']]);
          $cat = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          echo $e->getMessage();
        }

        ?>
        <h2>Les cours de la même catégorie (<?php echo $cat[0]['nom_categorie'] ?>)</h2>
        <div class="containerVideoCate">

          <?php foreach ($cat as $cat) : ?>
            <a href="watch.php?id=<?php echo $cat['id_formation'] ?>" class="videoBox">
              <video src="./video/vid1.mp4"></video>
              <div class="text">
                <h3><?php echo $cat['titre'] ?></h3>
                <h4><?php echo $cat['nom'] . ' ' . $cat['prenom'] ?></h4>
                <p>Publié : <?php
                            $date2 = date("d-m-Y", strtotime($cat['date_ajout']));
                            echo $date2 ?></p>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </main>
</body>

</html>