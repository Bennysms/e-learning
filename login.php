<?php
session_start();
include './config/db.php';
if ($_SESSION['auth']) {
   if ($_SESSION['user']['role'] == 'Formateur') {
      header('Location:formations.php');
   } else {
      header('Location:mesformations.php');
   }
} else {
   if (isset($_POST['valider'])) {
      if (!empty($_POST['email']) && !empty($_POST['password'])) {
         $email = $_POST['email'];
         $password = $_POST['password'];
         try {
            $stmt = $pdo->prepare('SELECT * FROM Users WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
               $user = $stmt->fetch(PDO::FETCH_ASSOC);
               // verifier si c'est le même mot de passe
               if ($user['password'] !== $password) {
                  $error = 'email ou mot de passe incorrect';
               } else {
                  $_SESSION['user'] = $user;
                  $_SESSION['auth'] = true;
                  if ($_SESSION['user']['role'] == 'Formateur') {
                     header('Location:formations.php');
                  } else {
                     header('Location:mesformations.php');
                  }
               }
            } else {
               $error = 'Compte inexistant';
            }
         } catch (PDOException $e) {
            echo $e->getMessage();
         }
      } else {
         $error = 'Ne laissez pas des champs vide';
      }
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
   <title>Login</title>
</head>

<body>
   <div class="container-compte">
      <a href="index.php" id="indexPage">Menu principal</a>
      <!-- login form -->
      <div class="login">
         <h3>Se connecter</h3>
         <form action="" method="POST">
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
            <div class="input-label">
               <label for="email">Email</label>
               <input type="email" name="email" id="email" placeholder="votre email" required />
            </div>
            <div class="input-label">
               <label for="password">Mot de passe</label>
               <input type="password" name="password" id="password" placeholder="votre mot de passe" required />
               <i class="fa-solid fa-eye" id="eye"></i>
            </div>
            <input type="submit" value="Login" class="submit" name="valider" />
            <p class="use-compte">
               Vous n'avez pas de compte ?
               <a href="signup.php" id="btn-signup">Inscrivez-vous</a>
            </p>
         </form>
      </div>
   </div>
   <script>
      // afficher et cacher le password pour le login
      const eye = document.querySelector("#eye");
      const password = document.querySelector("#password");
      eye.addEventListener("click", () => {
         if (password.getAttribute("type") == "password") {
            password.setAttribute("type", "text");
            eye.classList.add("fa-eye-slash");
            eye.classList.remove("fa-eye");
         } else {
            password.setAttribute("type", "password");
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
         }
      });
   </script>
</body>

</html>