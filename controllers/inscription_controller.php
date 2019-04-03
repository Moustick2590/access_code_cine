<?php


function getInscription(){    
    
    $pseudo = $_SESSION["pseudo"];
    $passOne = $_SESSION["passOne"];
    $email = $_SESSION["email"];    
     

    $req = $bdd->prepare('INSERT INTO users (pseudo, pass, email) VALUES("'.$pseudo.'", "'.$passOne.'", "'.$email.'")');
    $req->execute();
    $req->fetch();
    
    header('Location: /accueil');
    
}
