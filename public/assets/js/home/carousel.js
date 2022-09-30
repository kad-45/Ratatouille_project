//Déclaration des Variables globales
let counter = 0;//Compteur qui permet de connaître l'image sur laquelle on se trouve.
let timer, elements, slides, slideWidth, speed, transition;

window.onload = () => {
  //On récupère le diaporama
  
  const diapo = document.querySelector('.diapo');

  //On récupère le data-speed
  speed = diapo.dataset.speed;
  transition = diapo.dataset.transition;

  elements = document.querySelector('.elements');

  //On clone la 1ère image
  let firstImage = elements.firstElementChild.cloneNode(true);

  //On injecte le clone à la fin du diapo
  elements.appendChild(firstImage);

  slides = Array.from(elements.children);
  //console.log(slides);

  //On récupère la largeur d'une slide
  slideWidth = diapo.getBoundingClientRect().width;

  //On récupère les flêches
  let next = document.querySelector('.fa-chevron-right');
  let preview = document.querySelector('.fa-chevron-left');


  //On applique l'écouteur d'évenement.
  next.addEventListener('click', slideNext);
  preview.addEventListener('click', slidePreview);

  //On automatise le défilement
  timer = setInterval(slideNext, speed);

  //On gère l'arrêt et la reprise
  diapo.addEventListener('mouseover', stopTimer);
  diapo.addEventListener('mouseout', startTimer);

}

/**
 * La fonction slideNext() fait défiler le diaporama vers la droite.
*/
function slideNext() {
  //On va incrémenter le compteur
  counter++;
  elements.style.transition = transition+'ms linear';

  let decal = -slideWidth * counter;
  elements.style.transform = `translateX(${decal}px)`;

  //On attend la fin de la transition et on recharge les images de façon cachée
  setTimeout(function() {
      if ( counter >= slides.length - 1) {
        counter = 0;
        elements.style.transition ='unset';
        elements.style.transform = 'translateX(0)';
      }
  }, transition);
}

/**
 * Cette fonction fat défiler le diaporama vers la gauche
 */

function slidePreview() {
  //On décrémente le compteur
  counter--;
  elements.style.transition = transition+'ms linear';

  if (counter < 0) {
      counter = slides.length - 1;
      let decal = -slideWidth * counter;
      elements.style.transition ='unset';
      elements.style.transform = `translateX(${decal}px)`;
      setTimeout(slidePreview, 1);
  
    }

    let decal = -slideWidth * counter;
    elements.style.transform = `translateX(${decal}px)`;

}

function stopTimer() {
  clearInterval(timer);
}

function startTimer() {
  timer = setInterval(slideNext, speed);
}