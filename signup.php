<?php
include './config/db.php';

if (isset($_POST['signUp'])) {
   if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['role']) && !empty($_POST['password1']) && !empty($_POST['password2']) && !empty($_FILES['photo'])) {
      $pass1 = $_POST['password1'];
      $pass2 = $_POST['password2'];
      $nom = $_POST['nom'];
      $prenom = $_POST['prenom'];
      $email = $_POST['email'];
      $role = $_POST['role'];
      $photo = $_FILES['photo'];
      // verifier si les deux mot de passe sont correctes
      if ($pass1 === $pass2) {
         // verfier si l'email existe déjà
         $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ? ");
         $stmt->execute([$email]);
         // si l'utilisateur existe
         if ($stmt->rowCount() > 0) {
            $error = 'Utilisateur existant';
         }
         // si aucun utilisateur n'est trouvé
         else {
            // Enregistrer la photo et le lien absolu
            $fileName = $nom . '_' . uniqid() . '_' . $photo['name'];
            $filePath = 'media/' . $fileName;
            move_uploaded_file($photo['tmp_name'], $filePath);
            try {
               // Insérer dans la table un Utilisateur
               $stmt2 = $pdo->prepare("INSERT INTO Users (nom, prenom, email, password, role, photo) VALUES (?, ?, ?, ?, ?, ?)");
               $stmt2->execute([$nom, $prenom, $email, $pass1, $role, $fileName]);
               $succes = 'Compte crée avec succès';
            } catch (PDOException $e) {
               echo $e->getMessage();
            }
         }
      } else {
         $error = 'Veuillez entrer le même mot de passe';
      }
   } else {
      $error = 'Ne laissez pas des champs vide';
   }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style/login.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <title>Sign Up</title>
</head>

<body>
   <div class="container-compte">
      <a href="index.php" id="indexPage">Menu principal</a>
      <!-- signup form -->
      <div class="signup">
         <h3>S'inscrire</h3>
         <form method="POST" enctype="multipart/form-data" id="formSign">
            <!-- message d'erreur -->
            <p id="error-signUp" <?php if (isset($error)) {
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
                  <label for="nom">Nom</label>
                  <input type="text" name="nom" id="nom" placeholder="votre nom" required />
               </div>
               <div class="input-label">
                  <label for="prenom">Prénom</label>
                  <input type="text" name="prenom" id="prenom" placeholder="votre prénom" required />
               </div>
            </div>
            <!-- email -->
            <div class="input-label">
               <label for="email">Email</label>
               <input type="email" name="email" id="email" placeholder="votre email" required />
            </div>
            <!-- role et photo -->
            <div class="role-photo">
               <!-- rôle -->
               <div class="input-label">
                  <label for="role">Fonction</label>
                  <select name="role" id="role" required>
                     <option value="">Votre profession</option>
                     <option value="Formateur">Formateur</option>
                     <option value="Etudiant">Etudiant</option>
                     <option value="Expert">Expert</option>
                     <option value="Adherant">Adhérant</option>
                     <option value="Autres">Autres</option>
                  </select>
               </div>
               <!-- photo de profile -->
               <div class="input-label">
                  <label for="photo">Photo de profile</label>
                  <input type="file" name="photo" id="photo" placeholder="votre prénom" accept="image/*" required />
               </div>
            </div>
            <!-- mot de passe -->
            <div class="mdp">
               <div class="input-label">
                  <label for="password1">Mot de passe</label>
                  <input type="password" name="password1" id="password-signup" placeholder="Entrer un mot de passe" required />
                  <i class="fa-solid fa-eye" id="eye-signup"></i>
               </div>
               <div class="input-label">
                  <label for="password2">Confirmer le mot de passe</label>
                  <input type="password" name="password2" id="password2" placeholder="Entre un mot de passe" required />
                  <i class="fa-solid fa-eye" id="eye2"></i>
               </div>
            </div>
            <input type="submit" value="Sign Up" class="submit btn-signup" name="signUp" />
            <p class="use-compte">
               Vous avez déjà un compte ?
               <a href="login.php" id="btn-login">Connectez-vous</a>
            </p>
         </form>
      </div>
   </div>
   <script>
      // afficher et cacher le password pour le sign up de confirmation
      const password2 = document.querySelector("#password2");
      const eye2 = document.querySelector("#eye2");
      eye2.addEventListener("click", () => {
         if (password2.getAttribute("type") == "password") {
            password2.setAttribute("type", "text");
            eye2.classList.add("fa-eye-slash");
            eye2.classList.remove("fa-eye");
         } else {
            password2.setAttribute("type", "password");
            eye2.classList.remove("fa-eye-slash");
            eye2.classList.add("fa-eye");
         }
      });
      // afficher et cacher le password pour le sign up
      const passwordSignup = document.querySelector("#password-signup");
      const eyeSignup = document.querySelector("#eye-signup");
      eyeSignup.addEventListener("click", () => {
         if (passwordSignup.getAttribute("type") == "password") {
            passwordSignup.setAttribute("type", "text");
            eyeSignup.classList.add("fa-eye-slash");
            eyeSignup.classList.remove("fa-eye");
         } else {
            passwordSignup.setAttribute("type", "password");
            eyeSignup.classList.remove("fa-eye-slash");
            eyeSignup.classList.add("fa-eye");
         }
      });
   </script>
</body>

</html>