const header = document.querySelector("#section-1 header");
// fonction pour le scroll
function checkScroll() {
  // Si la position de défilement verticale est supérieure à 100 pixels
  if (window.scrollY > 70) {
    // Ajouter la classe "scrolled" à l'élément
    header.classList.add("scrolled");
  } else {
    // Sinon, retirer la classe "scrolled" de l'élément
    header.classList.remove("scrolled");
  }
}
window.addEventListener("scroll", checkScroll);
