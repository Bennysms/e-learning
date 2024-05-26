<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mes formations</title>
   <link rel="stylesheet" href="./style/compte.css">
   <link rel="stylesheet" href="./style/mesformations.css">
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
         <!-- container des participant -->
         <div class="mesFormations">
            <header>
               <h3>Mes formations</h3>
               <div><button class="add">
                     <i class="fa-solid fa-plus"></i> Afficher mes fichiers
                  </button>
                  <button class="close">
                     <i class="fa-solid fa-xmark"></i> Fermer
                  </button>
               </div>
            </header>
            <!-- mes fichiers -->
            <div class="contentFichier">
               <h2 class="header-h2">Mes fichiers</h2>
               <div class="fichierContainer">
                  <div class="fichierCard">
                     <div class="img">
                        <img src="./images/pdf-logo.svg" alt="">
                     </div>
                     <div class="text">
                        <h2>Nom du fichier</h2>
                        <h3>Categorie du fichier</h3>
                        <h4>Nom du l'auteur</h4>
                        <a href="#" download>Télécharger</a>
                     </div>
                  </div>
                  <div class="fichierCard">
                     <div class="img">
                        <img src="./images/pdf-logo.svg" alt="">
                     </div>
                     <div class="text">
                        <h2>Nom du fichier</h2>
                        <h3>Categorie du fichier</h3>
                        <h4>Nom du l'auteur</h4>
                        <a href="#" download>Télécharger</a>
                     </div>
                  </div>
                  <div class="fichierCard">
                     <div class="img">
                        <img src="./images/pdf-logo.svg" alt="">
                     </div>
                     <div class="text">
                        <h2>Nom du fichier</h2>
                        <h3>Categorie du fichier</h3>
                        <h4>Nom du l'auteur</h4>
                        <a href="#" download>Télécharger</a>
                     </div>
                  </div>
                  <div class="fichierCard">
                     <div class="img">
                        <img src="./images/pdf-logo.svg" alt="">
                     </div>
                     <div class="text">
                        <h2>Nom du fichier</h2>
                        <h3>Categorie du fichier</h3>
                        <h4>Nom du l'auteur</h4>
                        <a href="#" download>Télécharger</a>
                     </div>
                  </div>
                  <div class="fichierCard">
                     <div class="img">
                        <img src="./images/pdf-logo.svg" alt="">
                     </div>
                     <div class="text">
                        <h2>Nom du fichier</h2>
                        <h3>Categorie du fichier</h3>
                        <h4>Nom du l'auteur</h4>
                        <a href="#" download>Télécharger</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="mesFormationsContainer">
               <?php
               session_start();
               include './config/db.php';
               try {
                  // $stmt3 = $pdo->prepare("SELECT * FROM Participants WHERE statut = 'Accepté'");
                  // $stmt3 = $pdo->prepare("SELECT f.*, u.nom, u.prenom, u.photo FROM Formations f JOIN Users u ON f.formateur_id = u.id_user;");
                  //                   $stmt3 = $pdo->prepare("SELECT f.*, u.nom, u.prenom FROM Formations f
                  // JOIN Users u ON f.formateur_id = u.id_user
                  // JOIN Participants p ON f.id_categorie = p.id_categorie
                  // WHERE p.statut = 'Accepté'");
                  $stmt3 = $pdo->prepare("SELECT f.*, u.nom, u.prenom, u.photo FROM Formations f JOIN Users u ON f.formateur_id = u.id_user JOIN Participants p ON f.id_categorie = p.id_categorie WHERE p.statut = 'Accepté' AND p.id_user = ?");
                  $stmt3->execute([$_SESSION['user']['id_user']]);

                  if ($stmt3->rowCount() > 0) {
                     while ($cours = $stmt3->fetch(PDO::FETCH_ASSOC)) {
               ?>
                        <a href="watch.php?id=<?= $cours['id_formation'] ?>" class="videoBox">
                           <video src="<?= 'videos/' . $cours['video'] ?>"></video>
                           <div class="contentText">
                              <img src="<?= 'media/' . $cours['photo'] ?>">
                              <div>
                                 <h2><?= $cours['titre'] ?></h2>
                                 <p>Publié par <?= $cours['nom'] . ' ' . $cours['prenom'] ?></p>
                                 <p>Publié : <?= date("d-m-Y", strtotime($cours['date_ajout'])) ?></p>
                              </div>
                           </div>
                        </a>
               <?php
                     }
                  } else {
                     echo "Vous n'avez aucune formation.";
                  }
               } catch (PDOException $e) {
                  echo "Erreur : " . $e->getMessage();
               }
               ?>
            </div>
         </div>
      </div>
   </main>
   <script>
      const btnAdd = document.querySelector('button.add');
      const btnClose = document.querySelector('button.close');
      const contentFichier = document.querySelector('.contentFichier ')

      btnAdd.addEventListener('click', () => {
         contentFichier.classList.add('active');
         btnClose.style.display = 'block'
         btnAdd.style.display = 'none'

      })
      btnClose.addEventListener('click', () => {
         contentFichier.classList.remove('active');
         btnClose.style.display = 'none'
         btnAdd.style.display = 'block'
      })
   </script>
</body>

</html>