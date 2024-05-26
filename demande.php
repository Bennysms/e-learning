<?php
session_start();
include './config/db.php';
if (isset($_POST['valider'])) {
   if (!empty($_POST['email']) && !empty($_POST['cat'])) {
      // enregistrer l'id de l'utilisateur connecté
      $id_user = $_SESSION['user']['id_user'];
      $email = $_POST['email'];
      $cat = $_POST['cat'];

      try {
         $stmt1 = $pdo->prepare("SELECT * FROM Participants WHERE id_user = ? AND id_categorie = ? AND (statut = 'Accepté' OR statut = 'En attente') ");
         $stmt1->execute([$id_user, $cat]);
         if ($stmt1->rowCount() > 0) {
            $error = 'Vous avez déjà demandé cette formation';
         } else {
            try {
               $stmt2 = $pdo->prepare("INSERT INTO Participants (id_user, email, id_categorie) VALUES (?, ?, ?)");
               $stmt2->execute([$id_user, $email, $cat]);
               $succes = 'Demande effectuée avec succès';
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
   <title>Suivre une formation</title>
   <link rel="stylesheet" href="./style/compte.css">
   <link rel="stylesheet" href="./style/demande.css">
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
         <!-- container des demandes -->
         <div class="demande">
            <header>
               <h3>Demander une formation</h3>
            </header>
            <!-- formulaire de demande de formation -->
            <div class="add">
               <h3>Demander une formation</h3>
               <form method="POST" class="cours">
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
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Entrer votre email" required />
                     </div>
                     <div class="input-label">
                        <label for="categorie">Catégorie de la formation</label>
                        <select name="cat" id="categorie" required>
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
                  </div>
                  <input type="submit" value="Envoyer" class="submit" name="valider" />
               </form>
            </div>
         </div>
      </div>
   </main>
</body>

</html>