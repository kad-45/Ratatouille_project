/* 1er méthode pour l'enregistrement d'un utilisateur----------*/
function confirmed(elem) {
  let elmTabConfirmed = elem.name.split('_');
  let selectorElem = '#' + elem.id;
  let selector = '#' + elmTabConfirmed[1];
  let elementVal = document.querySelector(selector).value
  if (elem.value !== elementVal) {

      document.querySelector(selector).style.border = '1px solid red';
      document.querySelector(selectorElem).style.border = '1px solid red';

  }
}

/*2ème méthode*/
/*document.querySelector('#confirmed_email').addEventListener('blur', (event) => {
    let email = document.querySelector('#email').value;
    if (this.value !== email) {
        event.target.style.border = '1px solid red';
        document.querySelector('#email').style.border = '1px solid red';
    }
});*/

