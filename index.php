<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>E_LEARNING</title>
</head>

<body>
  <section id="section-1">
    <header>
      <div class="container header-flex">
        <a href="#" class="logo">
          <img src="./images/iteam.jpeg" alt="logo i-team" />
          <span class="">E-Learning</span>
        </a>
        <!-- <nav class="flex gap-10 text-white nav-link">
            <a href="#">Acceuil</a>
            <a href="#">Cours</a>
            <a href="#">A propos</a>
            <a href="#">Contact</a>
          </nav> -->
        <div class="btn-group">
          <a href="login.php" class="btn" id="header-login">Login</a>
          <a href="signup.php" class="btn" id="header-signup">Sign Up</a>
        </div>
      </div>
    </header>
    <div class="section-1-container container">
      <div class="container-flex">
        <p class="para-1">
          <i class="fa-solid fa-play"></i>ON-DEMAND VIDEO TRAINING
        </p>
        <h1>
          Education Opens <br />
          up the Mind
        </h1>
        <p class="para-2">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit
          tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
        </p>
        <a href="" class="btn">Start Courses</a>
      </div>
    </div>
  </section>
  <section id="section-2">
    <div class="container">
      <div class="content-1">
        <h2>Technologies You Will Learn</h2>
        <div class="logo-image">
          <img src="./images/html5.svg" alt="" />
          <img src="./images/css3.svg" alt="" />
          <img src="./images/js.svg" alt="" />
          <img src="./images/node-js.svg" alt="" />
          <img src="./images/vuejs.svg" alt="" />
          <img src="./images/react.svg" alt="" />
          <img src="./images/python.svg" alt="" />
          <img src="./images/angular.svg" alt="" />
        </div>
      </div>
      <div class="content-2">
        <h2 class="content-2-title">Popular Courses</h2>
        <div class="content-2-container">
          <!-- box-1 -->
          <div class="content-2-box">
            <img src="./images/html.jpg" alt="" />
            <div class="box-text">
              <h2 class="box-title">HTML5/CSS3 Essentials</h2>
              <p class="box-para">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex
                laborum sed reprehenderit quae, accusamus animi?
              </p>
              <a href="">See more...</a>
            </div>
          </div>
          <!-- box-2 -->
          <div class="content-2-box">
            <img src="./images/html.jpg" alt="" />
            <div class="box-text">
              <h2 class="box-title">HTML5/CSS3 Essentials</h2>
              <p class="box-para">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex
                laborum sed reprehenderit quae, accusamus animi?
              </p>
              <a href="">See more...</a>
            </div>
          </div>
          <!-- box-3 -->
          <div class="content-2-box">
            <img src="./images/html.jpg" alt="" />
            <div class="box-text">
              <h2 class="box-title">HTML5/CSS3 Essentials</h2>
              <p class="box-para">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex
                laborum sed reprehenderit quae, accusamus animi?
              </p>
              <a href="">See more...</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <div class="container">
      <div class="div-1">
        <img src="./images/iteam.jpeg" alt="" />
        <p>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
          ad minim.
        </p>
        <div class="socials">
          <a href=""> <i class="fa-brands fa-facebook"></i></a>
          <a href=""><i class="fa-brands fa-x-twitter"></i></a>
          <a href=""><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>

      <div class="div-2">
        <h3>Popular courses</h3>
        <div class="link">
          <a href="">HTML5/CSS3 Essentials</a>
          <a href="">Become a PHP Master</a>
          <a href="">WordPress Basic Tutorial</a>
          <a href="">JavaScript Development</a>
          <a href="">Introduction to Coding</a>
        </div>
      </div>
      <div class="div-2 div-3">
        <h3>Contact</h3>
        <div>
          <p>Adresse</p>
          <span>Tunis</span>
        </div>
        <div>
          <p>Phone</p>
          <span>258987626</span>
        </div>
        <div>
          <p>Email</p>
          <span>ghh@gmail.com</span>
        </div>
      </div>
    </div>
  </footer>

  <script src="./script/index.js"></script>

</body>

</html>