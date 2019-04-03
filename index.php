<?php

session_start();

$uri = $_SERVER['REQUEST_URI'];
$uriExplode = explode( "/" , $uri);
$uri1 = $uriExplode[2];





include_once 'models/model.php';
include_once 'controllers/controller.php';


switch($uri1){
        
    case "" :
        
        header('Location: /access_code_cine/accueil');
        break;

        
    case "accueil" :
        
        if(isset($_POST['pseudo']) && isset($_POST['pass']) ){
            
            getAccueil($_POST['pseudo'], $_POST['pass'],$uri1);
            
        }else{
            
            getAccueil("", "", $uri1);
            
        }
        
        break;
        
        
    case "films":
        
        if(isset($uriExplode[3])){
            
            $id = $uriExplode[3];
            $pseudo= "";
            $pass ="";
            getDescriptions($pseudo, $pass, $uri1, $id);
            
        } else {
            
            $pseudo= "";
            $pass ="";
            getFilms($pseudo,$pass,$uri1);
            
        }
        
        break;


        
        
    case "membres" :
        if(isset($_POST['pseudo']) && isset($_POST['pass']) ){
            
            getUsers($_POST['pseudo'], $_POST['pass'],$uri1);
            
        }else{
            
            getUsers("", "", $uri1);
            
        }

        if(isset($_POST['titre']) && isset($_POST['genre']) && isset($_POST['realisateur']) && isset($_POST['realisateur2']) && isset($_POST['acteur']) && isset($_POST['acteur2']) && isset($_POST['acteur3']) && isset($_POST['annee']) && isset($_POST['description'])){
            
                $nomImage = $_FILES['image']['name'];
                $_FILES["image"]["tmp_name"];
                move_uploaded_file($_FILES["image"]["tmp_name"], "public/img/$nomImage");

                addFilm($_POST['titre'], $_POST['genre'], $_POST['realisateur'], $_POST['realisateur2'], $_POST['acteur'], $_POST['acteur2'], $_POST['acteur3'], $_POST['annee'], $_POST['description'], $_SESSION['pseudo']);

         }else{

        }
        
         break;


    case "deconnexion" :
        
        session_unset();
        
        header('Location: /access_code_cine/accueil');
        
        break;
        
        
    default :
        
        header('Location: /access_code_cine/accueil');
        
    exit;   

}

?>
