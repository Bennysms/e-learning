<?php
session_start();
include './config/db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes fichiers</title>
  <link rel="stylesheet" href="./style/compte.css">
  <link rel="stylesheet" href="./style/mesfichiers.css">
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
      <!-- container des fichiers -->
      <div class="mesFichiers">
        <header>
          <h3>Mes fichiers</h3>
          <div><button class="add">
              <i class="fa-solid fa-plus"></i> Ajouter un fichier
            </button>
            <button class="close">
              <i class="fa-solid fa-xmark"></i> Fermer le formualire
            </button>
          </div>
        </header>
        <!-- formulaire d'ajout des fichiers -->
        <div class="addFichier">
          <h3>Ajouter un fichier</h3>
          <form action="" class="cours" method="POST" enctype="multipart/form-data">
            <p id="error-signUp">Ce compte est existant</p>
            <!-- names -->
            <div class="name">
              <div class="input-label">
                <label for="titre">Titre du fichier</label>
                <input type="text" name="titre" id="titre" placeholder="Entrer le titre" required />
              </div>
            </div>
            <!-- categorie et video -->
            <div class="role-photo">
              <!-- categorie -->
              <div class="input-label">
                <label for="categorie">Catégorie du fichier</label>
                <select name="categorie" id="categorie">
                  <option value="">Choisir une catégorie</option>
                  <option value="Web">Web</option>
                  <option value="Mobile">Mobile</option>
                  <option value="Design">Design</option>
                </select>
              </div>
              <!-- fichier -->
              <div class="input-label">
                <label for="photo">Fichier</label>
                <input type="file" name="fichier" id="video" accept=".pdf" required />
              </div>
            </div>
            <input type="submit" value="Ajouter" class="submit" name="valider" />
          </form>
        </div>
        <!-- container fichier -->
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
    </div>
  </main>
  <script>
    const btnAdd = document.querySelector('button.add');
    const btnClose = document.querySelector('button.close');
    const addFichier = document.querySelector('.addFichier ')

    btnAdd.addEventListener('click', () => {
      addFichier.classList.remove('active');
      btnClose.style.display = 'block'
      btnAdd.style.display = 'none'

    })
    btnClose.addEventListener('click', () => {
      addFichier.classList.add('active');
      btnClose.style.display = 'none'
      btnAdd.style.display = 'block'
    })
  </script>
</body>

</html>