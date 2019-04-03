<?php

$errorMsgPseudoLogin="";
$errorMsgPassOne="";
$errorMsgPassTwo="";
$errorMsgEmail="";

   
    
/* pseudo */
if (preg_match("#^([a-zA-Z0-9-_]{2,36})$#", $_POST["pseudo"])) {
    $pseudo = $_POST["pseudo"];
    
    $bdd = new PDO('mysql:host=localhost;dbname=accesscodecine;charset=utf8', 'root', '');
    $req = $bdd->prepare("SELECT pseudo FROM users WHERE pseudo = '".$pseudo."'");
    $req->execute();
    $resultat = $req->fetch();   
    
    if ($_POST['pseudo'] == $resultat['pseudo']){
    $errorMsgPseudoLogin = 'Ce pseudo existe déjà !';
    } 
    
} else {
     $errorMsgPseudoLogin = 'Pseudo incorrect'; 
}


/* MDP ONE */
if (preg_match("#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{5,10})$#", $_POST["passOne"])) {
    $passOne = $_POST["passOne"];
} else {
    $errorMsgPassOne = 'Mdp incorrect (au moins une minuscule, une majuscule, un chiffre et un caractère spécial)'; 
}

/* MDP TWO */
if ($_POST["passTwo"] == $_POST["passOne"]) {
    $passTwo = $_POST["passTwo"];
} else {
    $errorMsgPassTwo = 'Mdp non identique'; 
}

/* EMAIL */
if (preg_match("#^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$#", $_POST["email"])) {
    $email = $_POST["email"]; 
    
    $bdd = new PDO('mysql:host=localhost;dbname=accesscodecine;charset=utf8', 'root', '');
    $req = $bdd->prepare("SELECT email FROM users WHERE email = '".$email."'");
    $req->execute();
    $resultat = $req->fetch();   
    
    if ($_POST['email'] == $resultat['email']){
    $errorMsgEmail = 'Cet email existe déjà !';
    } 
    
} else {
    $errorMsgEmail = 'Email incorrect'; 
}

/* ERROR */
if((empty($errorMsgPseudoLogin)) && (empty($errorMsgPassOne))  && (empty($errorMsgPassTwo)) && (empty($errorMsgEmail))){
    
    $bdd = new PDO('mysql:host=localhost;dbname=accesscodecine;charset=utf8', 'root', '');
    $req = $bdd->prepare('INSERT INTO users (pseudo, pass, email) VALUES("'.$pseudo.'", "'.$passOne.'", "'.$email.'")');
    $req->execute();
    $req->fetch();
    
    $msg = "Nom: ".$pseudo.", passOne:".$passOne.", passTwo:".$passTwo.", email:".$email;
    echo json_encode(['code'=>200]);
    
} else {
    
    echo json_encode([
        'code'=>404, 
        'errorMsgPseudoLogin'=>$errorMsgPseudoLogin,
        'errorMsgPassOne'=> $errorMsgPassOne,
        'errorMsgPassTwo'=> $errorMsgPassTwo,
        'errorMsgEmail'=> $errorMsgEmail
    ]);
}