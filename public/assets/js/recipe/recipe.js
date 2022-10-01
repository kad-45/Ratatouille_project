/*----script pour le formulaire de création et modification d'une recette-----*/

const addIngredient = document.querySelector('#add_ingredient');
addIngredient.addEventListener("click", (e) => {
    let rcipeIngredient = document.querySelector('#h_ingredient #recipe_ingredient');
    let clone = rcipeIngredient.cloneNode(true);
    document.querySelector('#fields_ingredient')
        .appendChild(clone);

});
const addSteps = document.querySelector('#add_steps');
addSteps.addEventListener("click", (e) => {
    let steps = document.querySelector('#h_steps #recipe_steps');
    let clone = steps.cloneNode(true);
    document.querySelector('#fields_steps')
        .appendChild(clone);

});

function removeElement(elm) {
  elm.parentNode.parentNode.parentNode.remove();
}