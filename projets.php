<?php
session_start();
include './config/db.php';
$id_user = $_SESSION['user']['id_user'];
if (isset($_POST['valider'])) {
   if (!empty($_POST['titre']) && !empty($_POST['cat']) && !empty($_POST['lien']) && !empty($_FILES['photo'])) {
      $titre = $_POST['titre'];
      $cat = $_POST['cat'];
      $lien = $_POST['lien'];
      $photo = $_FILES['photo'];

      try {
         $stmt = $pdo->prepare("SELECT * FROM Projets WHERE id_user = ? AND id_categorie = ? AND lien = ? ");
         $stmt->execute([$id_user, $cat, $lien]);

         if ($stmt->rowCount() > 0) {
            $error = 'Ce projet existe déjà dans la base de données';
         } else {
            // Enregistrer la photo et le lien absolu
            $fileName =   uniqid() . '_' . $photo['name'];
            $filePath = 'projet/' . $fileName;
            move_uploaded_file($photo['tmp_name'], $filePath);

            try {
               // Insérer dans la table un Utilisateur
               $stmt2 = $pdo->prepare("INSERT INTO Projets (id_categorie, id_user, photo, lien) VALUES (?, ?, ?, ?)");
               $stmt2->execute([$cat, $id_user, $fileName, $lien]);
               $succes = 'Projet ajouté avec succès';
            } catch (PDOException $e) {
               echo $e->getMessage();
            }
         }
      } catch (PDOException $e) {
         echo $e->getMessage();
      }
   }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Projets</title>
   <link rel="stylesheet" href="./style/compte.css">
   <link rel="stylesheet" href="./style/projets.css">
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
         <!-- container des projets -->
         <header>
            <h3>Mes projets</h3>
            <div><button class="add">
                  <i class="fa-solid fa-plus"></i> Ajouter un projet
               </button>
               <button class="close">
                  <i class="fa-solid fa-xmark"></i> Fermer le formualire
               </button>
            </div>
         </header>
         <!-- formulaire d'ajout des projets -->
         <div class="addProjets">
            <h3>Ajouter un projet réalisé</h3>
            <form method="POST" enctype="multipart/form-data" class="cours">
               <!-- message d'erreur -->
               <p id="error" <?php if (isset($error)) {
                                 echo 'style="display:block;"';
                              } else {
                                 echo 'style="display:none;"';
                              } ?>>
                  <?php if (isset($error)) {
                     echo $error;
                  } ?>
               </p>
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
                     <label for="titre">Titre du projet</label>
                     <input type="text" name="titre" id="titre" placeholder="Entrer le titre" required />
                  </div>
               </div>
               <!-- categorie et video -->
               <div class="role-photo">
                  <!-- categorie -->
                  <div class="input-label">
                     <label for="categorie">Catégorie du projet</label>
                     <select name="cat" id="categorie">
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
                  <!-- photo -->
                  <div class="input-label">
                     <label for="photo">Photo illustrative</label>
                     <input type="file" name="photo" id="video" accept="image/*" required />
                  </div>
               </div>
               <!-- lien du projet -->
               <div class="input-label">
                  <label for="desc">Lien vers ce projet</label>
                  <textarea name="lien" id="desc"></textarea>
               </div>
               <input type="submit" value="Ajouter" name="valider" class="submit" />
            </form>
         </div>
         <!-- container des projets -->
         <div class="containerProjets">
            <?php
            session_start();
            try {
               $stmt2 = $pdo->prepare("SELECT p.photo,u.nom,u.prenom,c.nom AS categorie_nom,p.lien FROM Projets p JOIN Users u ON p.id_user = u.id_user JOIN Categories c ON p.id_categorie = c.id_categorie WHERE p.id_user = ?");
               $stmt2->execute([$_SESSION['user']['id_user']]);
               if ($stmt2->rowCount() > 0) {
            ?>
                  <?php while ($projets = $stmt2->fetch(PDO::FETCH_ASSOC)) : ?>
                     <div class="boxProjets">
                        <img src=<?php echo 'projet/' . $projets['photo'] ?> alt="">
                        <div class="text">
                           <h3><?php echo $projets['titre'] ?></h3>
                           <h4>Categorie : <?php echo $projets['categorie_nom'] ?></h4>
                           <h5><?php echo $projets['nom'] . ' ' . $projets['prenom'] ?></h5>
                           <a href=<?php echo $projets['lien'] ?> class="btn">Lien vers le projet <i class="fa-solid fa-arrow-right" target="_blank"></i></a>
                        </div>
                     </div>
                  <?php endwhile; ?>
            <?php } else {
                  echo "vous n'avez aucune formation";
               }
            } catch (PDOException $e) {
               echo $e->getMessage();
            }
            ?>

         </div>
      </div>
   </main>
   <script>
      const btnAdd = document.querySelector('button.add');
      const btnClose = document.querySelector('button.close');
      const addProjets = document.querySelector('.addProjets ')

      btnAdd.addEventListener('click', () => {
         addProjets.classList.remove('active');
         btnClose.style.display = 'block'
         btnAdd.style.display = 'none'

      })
      btnClose.addEventListener('click', () => {
         addProjets.classList.add('active');
         btnClose.style.display = 'none'
         btnAdd.style.display = 'block'
      })
   </script>
</body>

</html>