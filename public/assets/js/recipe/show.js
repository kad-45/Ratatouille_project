
//--------------------- JS pour modifier ou supprimer un ingrédient ou une étape d'une recette-------------------------

//--------------Obtenir le modal pour modifier un ingrédient-------------------------------------

const modalIngredient = document.querySelector('.modal_ingredient');
//Cibler le boutton qui ouvre le modal
//Lorsque l'utilisateur clique sur le boutton modifier, le modal s'ouvre
let myBtnUpdate = document.querySelectorAll('.btn_update_ingredient');
myBtnUpdate.forEach(element => {
    element.addEventListener('click', () => {

        //alert(element.parentElement.parentElement.firstElementChild.textContent);
        //on va cibler le champ type hidden qui contient le (name=id) pour stocker l'id de l'ingrédient qu'on va modifier.
        
        document.getElementById('id_ingredient').value = element.parentElement.parentElement
            .getAttribute('id');
        document.querySelector('#id_name_ingredient').value = element.parentElement
            .parentElement
            .children[0].innerHTML;
        document.querySelector('#id_quantity_ingredient').value = element.parentElement
            .parentElement
            .children[1].innerHTML;
        document.querySelector('#id_unity_ingredient').value = element.parentElement
            .parentElement
            .children[2].innerHTML;
        modalIngredient.style.display = 'block ';
    })
});

//Obtenir le span qui ferme le modal

const spanIngredient = document.getElementsByClassName("close_modal_ingredient")[0];

//Lorsque l'utilisateur clique sur <span> (x), ferme le modal

spanIngredient.addEventListener('click', () => {
    modalIngredient.style.display = 'none';

});

//Lorsque l'utilisateur click sur le boutton fermer(btn_cancel)

const cancelBtn = document.querySelector('.btn_cancel_ingredient');
cancelBtn.addEventListener('click', () => {
    console.log('totot!!!!');
    modalIngredient.style.display = 'none';
});

//Lorsque l'utilisateur clique n'importe où en dehors du modal, ce dernier se ferme

window.addEventListener('click', (event) => {
    if (event.target == modalIngredient) {
        modalIngredient.style.display = 'none';
    }
});

//------------------Obtenir le modal pour supprimer un ingrédient-------------------------------------


//Lorsque l'utilisateur clique sur le boutton supprimer, le modal s'ouvre
//je dois cibler le champ type hidden qui contient le (name=id) pour stocker l'id de l'ingrédient qu'on va supprimer.

const modalIngredientDelete = document.querySelector('.modal_ingredient_delete');
let myBtnDelete = document.querySelectorAll('.btn_delete_ingredient');
myBtnDelete.forEach(element => {
    element.addEventListener('click', () => {
        document.querySelector('#id_ingredient_delete').value = element
            .previousSibling
            .parentElement
            .parentElement
            .getAttribute('id');
        modalIngredientDelete.style.display = 'block';
    });
});

//Lorsque l'utilisateur clique sur <span> (x), ferme le modal

document.getElementsByClassName("close_modal_ingredient_delete")[0].addEventListener('click', () => {
    modalIngredientDelete.style.display = 'none';

});

//Lorsque l'utilisateur click sur le boutton fermer(btn_cancel)

document.querySelector('.btn_cancel_ingredient_delete').
addEventListener('click', () => {
    modalIngredientDelete.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target == modalIngredientDelete) {
        modalIngredientDelete.style.display = 'none';
    }
});

//------------------------Obtenir le modal pour modifier les étapes-----------------------

const modalStep = document.querySelector('.modal_step');
//Cibler le boutton qui ouvre le modal
//Lorsque l'utilisateur clique sur le boutton modifier, le modal s'ouvre

let myBtnStep = document.querySelectorAll('.btn_update_step');
myBtnStep.forEach(element => {
    element.addEventListener('click', () => {

        //alert(element.parentElement.parentElement.firstElementChild.textContent);
        //je dois cibler le champ type hidden qui contient le (name=id)
        
        document.getElementById('id_step').value = element.parentElement.parentElement
            .getAttribute('id');
        //console.log('toto!!!!!!!!');
        document.querySelector('#id_nbr_step').value = element.parentElement
            .parentElement
            .children[0].textContent;
        document.querySelector('#id_description_step').value = element.parentElement
            .parentElement
            .children[1].textContent;
        modalStep.style.display = 'block';

    });
});

//Obtenir le span qui ferme le modal

const spanStep = document.getElementsByClassName("close_modal_step")[0];

//Lorsque l'utilisateur clique sur <span> (x), ferme le modal

spanStep.addEventListener('click', () => {
    modalStep.style.display = 'none';

});

//Lorsque l'utilisateur click sur le boutton fermer(btn_cancel)

const cancelBtnStep = document.querySelector('.btn_cancel_step');
cancelBtnStep.addEventListener('click',
    () => {
        modalStep.style.display = 'none';
    });

//Lorsque l'utilisateur clique en dehors du modal, ce dernier se ferme

window.addEventListener('click', (event) => {
    if (event.target == modalStep) {
        modalStep.style.display = 'none';
    }
});
//------------------Obtenir le modal pour supprimer une étape-----------

//Lorsque l'utilisateur clique sur le boutton supprimer, le modal s'ouvre
//je dois cibler le champ type hidden qui contient le (name=id) pour stocker l'id de l'étape qu 'on va supprimer.

const modalStepDelete = document.querySelector('.modal_step_delete');
let myBtnDeleteStep = document.querySelectorAll('.btn_delete_step');
myBtnDeleteStep.forEach(element => {
    element.addEventListener('click', () => {
        alert(element.previousSibling.parentElement.parentElement.getAttribute('id'));
        document.querySelector('#id_step_delete').value = element.previousSibling.parentElement
            .parentElement.getAttribute('id');
        modalStepDelete.style.display = 'block';
    });
});
//Lorsque l'utilisateur clique sur <span> (x), le modal se ferme.

document.getElementsByClassName('close_modal_step_delete')[0].addEventListener('click', () => {
    modalStepDelete.style.display = 'none';
});
//Lorsque l'utilisateur click sur le boutton fermer(btn_cancel)

document.querySelector('.btn_cancel_step_delete').addEventListener('click', () => {
    modalStepDelete.style.display = 'none';

});
//Lorsque l'utilisateur clique en dehors du modal, ce dernier se ferme

window.addEventListener('click', (event) => {
    if (event.target == modalStepDelete) {
        modalStepDelete.style.display = 'none';
    }
});
