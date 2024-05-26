<?php
include './config/db.php';
try {
   $stmt1 = $pdo->prepare("SELECT p.*, u.photo, u.nom, u.prenom,c.nom AS nom_categorie FROM Participants p JOIN Users u ON p.id_user = u.id_user JOIN Categories c ON p.id_categorie = c.id_categorie WHERE p.statut ='En attente' ");
   $stmt1->execute();
   $participants = $stmt1->fetchAll((PDO::FETCH_ASSOC));
} catch (PDOException $e) {
   echo $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Participants</title>
   <link rel="stylesheet" href="./style/compte.css">
   <link rel="stylesheet" href="./style/participants.css">
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
         <div class="top">
            <div class="titre">
               <h2>Les Candidatures aux formations</h2>
               <div><button class="add">
                     <i class="fa-solid fa-plus"></i> Ouvrir les candidatures
                  </button>
                  <button class="close">
                     <i class="fa-solid fa-xmark"></i> Fermer les candidatures
                  </button>
               </div>
            </div>
            <!-- container candidature -->
            <div class="containerParticipants">
               <?php
               if (count($participants)) {
               ?>
                  <?php foreach ($participants as $participant) : ?>
                     <div class="boxParticipant">
                        <div class="img">
                           <img src=<?php echo 'media/' . $participant['photo'] ?> alt="">
                           <div class="text">
                              <h3><?php echo $participant['nom'] . ' ' . $participant['prenom'] ?></h3>
                              <h4>Categorie : <?php echo $participant['nom_categorie'] ?></h4>
                           </div>
                        </div>
                        <div class="btns">
                           <a href="accepter.php?id=<?php echo $participant['id_participant'] ?>">Accepter</a>
                           <a href="refuser.php?id=<?php echo $participant['id_participant'] ?>">Réfuser</a>
                        </div>
                     </div>
                  <?php endforeach ?>
               <?php } else {
                  echo 'Aucune demande de formation en attente';
               }
               ?>

            </div>
         </div>
         <!-- bottom -->
         <div class="bottom">
            <?php
            try {
               $stmt2 = $pdo->prepare("SELECT p.*, u.photo, u.nom, u.prenom,u.role ,c.nom AS nom_categorie FROM Participants p JOIN Users u ON p.id_user = u.id_user JOIN Categories c ON p.id_categorie = c.id_categorie WHERE p.statut ='Accepté' ");
               $stmt2->execute();
               $accepte = $stmt2->fetchAll((PDO::FETCH_ASSOC));
            } catch (PDOException $e) {
               echo $e->getMessage();
            }

            ?>
            <h2 class="titre">Les participants acceptés aux formations</h2>
            <div class="containerBottom">
               <?php
               if (count($accepte)) {
               ?>
                  <?php foreach ($accepte as $acc) : ?>
                     <div class="boxBottom">
                        <img src=<?php echo 'media/' . $acc['photo'] ?> alt="">
                        <div class="textBottom">
                           <h2><?php echo $acc['nom'] . ' ' . $acc['prenom'] ?></h2>
                           <h3>Fonction : <?php echo $acc['role'] ?></h3>
                           <p>Type de formation : <?php echo $acc['nom_categorie'] ?></p>
                        </div>
                     </div>
                  <?php endforeach ?>
               <?php } else {
                  echo 'Aucun participant accepté';
               }
               ?>

            </div>
         </div>
      </div>
   </main>
   <script>
      const btnAdd = document.querySelector('button.add');
      const btnClose = document.querySelector('button.close');
      const containerParticipants = document.querySelector('.containerParticipants ')

      btnAdd.addEventListener('click', () => {
         containerParticipants.style.display = "grid"
         btnClose.style.display = 'block'
         btnAdd.style.display = 'none'

      })
      btnClose.addEventListener('click', () => {
         containerParticipants.style.display = "none"
         btnClose.style.display = 'none'
         btnAdd.style.display = 'block'
      })
   </script>
</body>

</html>