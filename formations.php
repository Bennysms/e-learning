<?php
session_start();
include './config/db.php';
if (isset($_POST['valider'])) {
  if (!empty($_POST['titre']) && !empty($_POST['categorie']) && !empty($_FILES['video']) && !empty($_POST['desc'])) {
    $titre = $_POST['titre'];
    $cat = $_POST['categorie'];
    $video = $_FILES['video'];
    $desc = $_POST['desc'];
    $id_user = $_SESSION['user']['id_user'];

    // verfier si le cours existe déjà dans la base de données
    try {
      $stmt = $pdo->prepare("SELECT * FROM Formations WHERE titre = ? AND id_categorie = ?");
      $stmt->execute([$titre, $cat]);
      if ($stmt->rowCount() > 0) {
        $error = 'Vous avez déjà ajouté ce cours';
      }
      // si la formation n'existe pas
      else {
        $fileName = uniqid() . '_' . $video['name'];
        $filePath = 'videos/' . $fileName;
        move_uploaded_file($video['tmp_name'], $filePath);
        // enregistrer la formation dans la base de données
        try {
          // Insérer dans la table un Utilisateur
          $stmt2 = $pdo->prepare("INSERT INTO Formations (titre, description, formateur_id, video, id_categorie) VALUES (?, ?, ?, ?, ?)");
          $stmt2->execute([$titre, $desc, $id_user, $fileName, $cat]);
          $succes = 'Formation ajoutée avec succès';
        } catch (PDOException $e) {
          echo $e->getMessage();
        }
      }
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } else {
    echo 'certains champs sont vides';
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formations</title>
  <link rel="stylesheet" href="./style/compte.css">
  <link rel="stylesheet" href="./style/formations.css">
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
      <!-- container des formations -->
      <div class="formations">
        <header>
          <h3>Les formations</h3>
          <div><button class="add">
              <i class="fa-solid fa-plus"></i> Ajouter une formation
            </button>
            <button class="close">
              <i class="fa-solid fa-xmark"></i> Fermer le formualire
            </button>
          </div>
        </header>
        <!-- formulaire d'ajout des formations -->
        <div class="addFormations">
          <h3>Ajouter une formation</h3>
          <form action="" class="cours" method="POST" enctype="multipart/form-data">
            <!-- message d'erreur -->
            <p id="error-signUp" <?php if (isset($error)) {
                                    echo 'style="display:block;"';
                                  } else {
                                    echo 'style="display:none;"';
                                  } ?>>
              <?php if (isset($error)) {
                echo $error;
              } ?>
              <!-- message de succès -->
            <p id="succes" <?php if (isset($succes)) {
                              echo 'style="display:block;"';
                            } else {
                              echo 'style="display:none;"';
                            } ?>>
              <?php if (isset($succes)) {
                echo $succes;
              } ?>
            </p>
            <!-- names -->
            <div class="name">
              <div class="input-label">
                <label for="titre">Titre de la formation</label>
                <input type="text" name="titre" id="titre" placeholder="Entrer le titre" required />
              </div>
            </div>
            <!-- categorie et video -->
            <div class="role-photo">
              <!-- categorie -->
              <div class="input-label">
                <label for="categorie">Catégorie</label>
                <select name="categorie" id="categorie" required>
                  <option value="">Choisir une catégorie</option>
                  <?php
                  try {
                    // charger les categories de formations
                    $sql = $pdo->prepare("SELECT * FROM Categories");
                    $sql->execute();
                    $categories = $sql->fetchAll(PDO::FETCH_ASSOC);
                  } catch (PDOException $e) {
                    echo $e->getMessage();
                  }
                  ?>

                  <?php foreach ($categories as $cat) : ?>
                    <option value="<?php echo $cat['id_categorie']; ?>"><?php echo $cat['nom'] ?></option>
                  <?php endforeach ?>

                </select>
              </div>
              <!-- video -->
              <div class="input-label">
                <label for="video">Vidéo</label>
                <input type="file" name="video" id="video" accept="video/*" required />
              </div>
            </div>
            <!-- desc -->
            <div class="input-label">
              <label for="desc">Description</label>
              <textarea name="desc" id="desc" required></textarea>
            </div>
            <input type="submit" value="Ajouter" class="submit" name="valider" />
          </form>
        </div>

        <!-- contenu de la page formation -->
        <div class="content">
          <div class="header">
            <p>Filtrer les formations par Categorie</p>
            <select name="" id="">
              <option value="">Choisir une catégorie</option>
              <?php
              try {
                // charger les categories de formations
                $sql = $pdo->prepare("SELECT * FROM Categories");
                $sql->execute();
                $categories = $sql->fetchAll(PDO::FETCH_ASSOC);
              } catch (PDOException $e) {
                echo $e->getMessage();
              }
              ?>

              <?php foreach ($categories as $cat) : ?>
                <option value="<?php echo $cat['id'] ?>"><?php echo $cat['nom'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <!-- container des videos -->
          <div class="videoContainer">
            <?php
            session_start();
            try {
              $stmt3 = $pdo->prepare("SELECT Formations.*, Users.photo,Users.nom,Users.prenom FROM Formations JOIN Users ON Formations.formateur_id = Users.id_user WHERE formateur_id = ?");
              $stmt3->execute([$_SESSION['user']['id_user']]);
              if ($stmt3->rowCount() > 0) {
            ?>
                <?php while ($cours = $stmt3->fetch(PDO::FETCH_ASSOC)) : ?>
                  <a href="watch.php?id=<?= $cours['id_formation'] ?>" class="videoBox">
                    <video src=<?= 'videos/' . $cours['video'] ?>>
                    </video>
                    <div class="contentText">
                      <img src=<?php echo 'media/' . $cours['photo'] ?>>
                      <div>
                        <h2><?php echo $cours['titre'] ?></h2>
                        <p>publier par <?php echo ' ' . $cours['nom'] . '-' . $cours['prenom'] ?></p>
                        <p>Publié :<?php
                                    $date = date("d-m-Y", strtotime($cours['date_ajout']));
                                    echo $date ?>
                        </p>
                      </div>
                    </div>
                  </a>
                <?php endwhile; ?>
            <?php } else {
                echo "vous n'avez aucune formation";
              }
            } catch (PDOException $e) {
              echo $e->getMessage();
            }
            ?>

          </div>
          <!-- ****fin*** -->
        </div>
      </div>
    </div>
    </div>
  </main>
  <script>
    const btnAdd = document.querySelector('button.add');
    const btnClose = document.querySelector('button.close');
    const addFormations = document.querySelector('.addFormations ')

    btnAdd.addEventListener('click', () => {
      addFormations.classList.remove('active');
      btnClose.style.display = 'block'
      btnAdd.style.display = 'none'

    })
    btnClose.addEventListener('click', () => {
      addFormations.classList.add('active');
      btnClose.style.display = 'none'
      btnAdd.style.display = 'block'
    })
  </script>
</body>

</html>