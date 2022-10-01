<?php
//On va récupérer toutes les valeures de formulaire.
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$company = $_POST['company'];
$message = str_replace("\n.", "\n..", $_POST['message']);

if (!empty($name) && !empty($email) && !empty($message)) 
     {
      
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));
    $company = htmlspecialchars(strip_tags($_POST['company']));
    $message = htmlspecialchars(strip_tags($_POST['message']));
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
  //Adresse email de déstinataire.  
    $to = "";
  //Sujet du mail à envoyer.
    $subject = "From: $name <$email>";
    //Fusionner toutes les valeurs utilisateur à l'intérieur de la variable body.
   $body = "Name: $name\nEmail: $email\nPhone: $phone\nCompany: $company\n\nMessage: $message\n\nRegards,////\n$name";
  //Courrier de l'expéditeur.
    $headers= "From: $email"; 
  //La méthode mail() envoie un mail. 
    if (mail($to, $subject, $body, $headers)) {
      
      echo "Votre méssage a bien été envoyer";
    
    }else{
      echo "Désolé impossible d'envoyer votre méssage";

    } 
    
  }else{
    echo "Entrez une adresse email valide!";
  }
}else{
 echo "Les champs : Nom, Email, Message sont obligatoires";
}

?>