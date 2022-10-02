
//Validation de formulaire de contact.---------------------------------
const nameUser = document.querySelector("#name");
const emailElement = document.querySelector("#email");
const phoneUser = document.querySelector('#phone');
const messageElement = document.querySelector("#msg");
const form = document.querySelector("#contact");
const span = document.querySelector(".button-area span");

//Validation du nom d'utilisateur------------------------------
const checkName = function() {
  let valid = false;

  const name = nameUser.value.trim();

    if(!isRequired(name)) {
        showError(nameUser, 'Le nom ne peut pas être vide');
      } else if (!isNameValid(name)) {
        showError(nameUser, "Le nom est invalide")
    } else {
        showSuccess(nameUser);
        valid = true;
    }
    return valid; 
  };


//Validation d'email------------------------------
 const checkEmail = function() {
    
  let valid = false;
    
    const email = emailElement.value.trim();

    if (!isRequired(email)) {
      showError(emailElement, "L'email ne peut pas être vide");
    } else if (!isEmailValid(email)) {
      showError(emailElement, "L'email est invalide");
    } else {
        showSuccess(emailElement);
        valid = true;
    }
    return valid;
  }

    //validation du N° de téléphone d'utilisateur------
    const checkPhone = function() {
      let valid = false;
      const phone = phoneUser.value.trim();
      if (!isRequired(phone)) {
        showError(phoneUser, 'Le N° de téléphone ne doit pas être vide');
  
      } else if (!isPhoneValid(phone)) {
          showError(phoneUser, 'Le N° de téléphone est invalide');
      } else {
        showSuccess(phoneUser);
        valid = true;
      }
      return valid;
    }
  
//Validation de méssage----------------
  const checkMessage = function() {
    let valid = false;
    const min = 40;
    const max = 500;

    const yourMessage = messageElement.value.trim();
    
    if (!isRequired(yourMessage)) {
      showError(messageElement, "Le message ne peut pas être vide");
  } else if (!isBetween(yourMessage.length, min, max)) {
      showError(messageElement, `La taille de votre méssage doit être comprise entre ${min} et ${max} caractères.`)
  } else {
      showSuccess(messageElement);
      valid = true;
  }
  return valid;
}

  //Déclaration de la fonction showError pour la géstion des erreurs

  const showError = function(input, message) {
    
    const formField = input.parentElement;
  
    formField.classList.remove('success');
    formField.classList.add('error');

    const error = formField.querySelector('span');
    error.textContent = message;
    error.style.color = 'red';
  };

  //Déclaration de la fonction showSuccess en cas de validation des champs de formulaire.

  const showSuccess = function(input) {
    const formField = input.parentElement;

    formField.classList.remove('error');
    formField.classList.add('success');

    const error = formField.querySelector('span');
    error.textContent = '';
  };

  const isEmailValid = function(email) {
    const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regex.test(email);
  };

  const isNameValid = function(name) {
    const myRegex = /^[a-zA-Z\s]*$/;
    return myRegex.test(name);
  };

  const isPhoneValid = function(phone) {
    const phoneRegex = /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/;
    return phoneRegex.test(phone);
  }

  const isRequired = value => value === '' ? false : true;

  const isBetween = (length, min, max) => length < min || length > max ? false : true;

  form.addEventListener('submit', (e) => {
    console.log('toto');
      let isNameValid = checkName();
      let isEmailValid = checkEmail();
      let isPhoneValid =  checkPhone();
      let isMessageValid = checkMessage();

      let isFormValid = isNameValid && isEmailValid && isMessageValid && isPhoneValid;
      if(!isFormValid){
        e.preventDefault();
      }
      
  });

  form.addEventListener('input', function (e) {
    switch (e.target.id) {
        case 'name':
            checkName();
            break;
        case 'email':
            checkEmail();
            break;
        case 'phone':
            checkPhone();
            break;
        case 'message':
            checkMessage();
            break;
    };
  });


