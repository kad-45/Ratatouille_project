

 //Obtenir le modal
const modal = document.querySelector('.modal');
//Cibler le boutton qui ouvre le modal
//Lorsque l'utilisateur clique sur le boutton supprimer,  le modal s'ouvre
let myBtn = document.querySelectorAll('#myBtn');
myBtn.forEach(element => {
  element.addEventListener('click', () => {
   let name = '#'+ element.getAttribute('model') + '_deleted_id';
   console.log(name);
   let data = 'data-' + element.getAttribute('model') + '_id';
   console.log(data);
    //je dois cibler le champ type hidden qui contient le (name=recipe_id)
    document.querySelector(name).value = element.getAttribute(data);
    console.log(element.getAttribute(data));
    modal.style.display = 'block';
  })
});

//Obtenir le span qui ferme le modal
 const span = document.getElementsByClassName("close_modal")[0];

//Lorsque l'utilisateur clique sur <span> (x), ferme le modal
span.addEventListener('click', () => {
  modal.style.display = 'none';

}); 

//Lorsque l'utilisateur click sur le boutton fermer(btn_cancel)
const cancelBtn = document.querySelector('.btn_cancel');
cancelBtn.addEventListener('click', () => {
  modal.style.display = 'none';
});

//Lorsque l'utilisateur clique n'importe où en dehors du modal, ce dernier se ferme
window.addEventListener('click', (event) => {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
});
