<?php

//// // // // // // // // // // // // //  AFFICHAGE ACCUEIL

function getAccueil($pseudo, $pass, $uri1){
    require('models/model.php');        
    $retour = $bdd->query('SELECT id, titre, image FROM films ORDER BY id DESC LIMIT 0, 10');
    
 
    
    verifForm($pseudo, $pass, $uri1, $retour);
}


//// // // // // // // // // // // // //  AFFICHAGE LISTE FILM
function getFilms($pseudo, $pass, $uri1){   
    require('models/model.php');    
    $retour = $bdd->query('SELECT id,titre,image FROM films');
    
    verifForm($pseudo, $pass, $uri1, $retour);
}
    
//// // // // // // // // // // // // //  AFFICHAGE 1 SEUL FILM

function getDescriptions( $pseudo, $pass, $uri1, $id){ 
    $id=intval($id);
    require('models/model.php');
    $retour = $bdd->query('SELECT films.id, films.titre, films.description, films.image, 
        GROUP_CONCAT(DISTINCT genres.nom SEPARATOR ", ") AS genre,
        GROUP_CONCAT(DISTINCT acteurs.nom SEPARATOR ", ") AS acteurs,
        GROUP_CONCAT(DISTINCT realisateur.nom SEPARATOR ", ") AS realisateurs,
        GROUP_CONCAT(DISTINCT annee.annee SEPARATOR ", ") AS annee,
        GROUP_CONCAT(DISTINCT users.pseudo SEPARATOR ", ") AS ajoutepar
        FROM films
        INNER JOIN annee ON films.annee=annee.id AND films.id='. $id . '
        INNER JOIN users ON films.ajoutepar=users.id AND films.id='. $id . '
        INNER JOIN genre_film ON genre_film.film_id= '. $id . ' 
        INNER JOIN genres ON genre_film.genre_id=genres.id 
        INNER JOIN acteurs_film ON acteurs_film.film_id='. $id . ' 
        INNER JOIN acteurs ON acteurs_film.acteur_id=acteurs.id 
        INNER JOIN realisateur_film ON realisateur_film.film_id='. $id . ' 
        INNER JOIN realisateur ON realisateur_film.realisateur_id=realisateur.id');
    
    verifForm($pseudo, $pass, $uri1, $retour);    
}


//// // // // // // // // // // // // //  AFFICHAGE MEMBRES

function getUsers($pseudo, $pass, $uri1){
    require('models/model.php');        
    $retour = $bdd->query('SELECT, pseudo FROM users');
 
    verifForm($pseudo, $pass, $uri1, $retour);
}

//// // // // // // // // // // // // //  AJOUTER FILM

function addFilm($titre, $genre, $realisateur, $realisateur2, $acteur, $acteur2, $acteur3, $annee, $description, $pseudo){
    require('models/model.php');
    
    $id_user = $bdd->query("SELECT id FROM users WHERE pseudo='$pseudo'");
    $id_user = $id_user->fetch();
    $id_user = $id_user[0];
    
    $verifTitre = $bdd->prepare("SELECT titre FROM films WHERE titre='$titre'");
    $verifTitre->execute();
    $res = $verifTitre->fetch();
    
    if($res != false){
        echo '<font color="red">Désolé, mais ce film existe déjà.</font>'; 
    } 
    else {
        
        $verifGenre = $bdd->prepare("SELECT id, nom FROM genres WHERE nom='$genre'");
        $verifGenre->execute();
        $res = $verifGenre->fetch();
        
        if($res != false){
            $id_genre = $res[0]; 
            } else {
                $verifGenre = $bdd->prepare("INSERT INTO genres(nom) VALUES ('$genre')") ;
                $verifGenre->execute();
                $req = $bdd->query("SELECT id FROM genres WHERE nom='$genre'");
                $id_genre = $req->fetch();
                $id_genre = $id_genre[0];
        }
        $id_genree = intval($id_genre);
        
        
        $verifReal = $bdd->prepare("SELECT id, nom FROM realisateur WHERE nom='$realisateur'");
        $verifReal->execute();
        $res = $verifReal->fetch();
        
        if($res != false){
            $id_real = $res[0]; 
            } else {
                $verifReal = $bdd->prepare("INSERT INTO realisateur(nom) VALUES ('$realisateur')");
                $verifReal->execute();
                $req = $bdd->query("SELECT id FROM realisateur WHERE nom='$realisateur'");
                $id_real = $req->fetch();
                $id_real = $id_real[0];
        }
                
        
        $verifReal2 = $bdd->prepare("SELECT id, nom FROM realisateur WHERE nom='$realisateur2'");
        $verifReal2->execute();
        $res = $verifReal2->fetch();
        
        if($res != false){
            $id_real2 = $res[0]; 
            } else {
                $verifReal2 = $bdd->prepare("INSERT INTO realisateur(nom) VALUES ('$realisateur2')");
                $verifReal2->execute();
                $req = $bdd->query("SELECT id FROM realisateur WHERE nom='$realisateur2'");
                $id_real2 = $req->fetch();
                $id_real2 = $id_real2[0];
        }
        
        
        $verifActeur = $bdd->prepare("SELECT id, nom FROM acteurs WHERE nom='$acteur'");
        $verifActeur->execute();
        $res = $verifActeur->fetch();
        
        if($res != false){
            $id_acteur = $res[0]; 
            } else {
                $verifActeur = $bdd->prepare("INSERT INTO acteurs(nom) VALUES ('$acteur')");
                $verifActeur->execute();
                $req = $bdd->query("SELECT id FROM acteurs WHERE nom='$acteur'");
                $id_acteur = $req->fetch();
                $id_acteur = $id_acteur[0];
        }
        $id_acteur = intval($id_acteur);
        
        
        $verifActeur2 = $bdd->prepare("SELECT id, nom FROM acteurs WHERE nom='$acteur2'");
        $verifActeur2->execute();
        $res = $verifActeur2->fetch();
        
        if($res != false){
            $id_acteur2 = $res[0]; 
            } else {
                $verifActeur2 = $bdd->prepare("INSERT INTO acteurs(nom) VALUES ('$acteur2')");
                $verifActeur2->execute();
                $req = $bdd->query("SELECT id FROM acteurs WHERE nom='$acteur2'");
                $id_acteur2 = $req->fetch();
                $id_acteur2 = $id_acteur2[0];
        }
        $id_acteur2 = intval($id_acteur2);
        
        
        $verifActeur3 = $bdd->prepare("SELECT id, nom FROM acteurs WHERE nom='$acteur3'");
        $verifActeur3->execute();
        $res = $verifActeur3->fetch();
        
        if($res != false){
            $id_acteur3 = $res[0]; 
            } else {
                $verifActeur3 = $bdd->prepare("INSERT INTO acteurs(nom) VALUES ('$acteur3')");
                $verifActeur3->execute();
                $req = $bdd->query("SELECT id FROM acteurs WHERE nom='$acteur3'");
                $id_acteur3 = $req->fetch();
                $id_acteur3 = $id_acteur3[0];
        }
        $id_acteur3 = intval($id_acteur3);
    
        
        $verifAnnee = $bdd->prepare("SELECT id, annee FROM annee WHERE annee='$annee'");
        $verifAnnee->execute();
        $res = $verifAnnee->fetch();
        
        if($res != false){
            $id_annee = $res[0]; 
            } else {
                $verifAnnee = $bdd->prepare("INSERT INTO annee(annee) VALUES ('$annee')");
                $verifAnnee->execute();
                $req = $bdd->query("SELECT id FROM annee WHERE annee='$annee'");
                $id_annee = $req->fetch();
                $id_annee = $id_annee[0];
        }
        $id_annee = intval($id_annee);
        
        $sql = "INSERT INTO films(titre, description, annee, ajoutepar, image) VALUES(\"$titre\",\"$description\",$id_annee,$id_user,'')";
        $verifFilm = $bdd->prepare($sql);
        $verifFilm->execute();
        
        $sql = "SELECT id FROM films WHERE titre=\"$titre\"";
        
        $req = $bdd->query($sql);
        $id_film = $req->fetch();
        $id_film = $id_film[0];
        $id_film = intval($id_film);        
        
        $genre_film = $bdd->prepare("INSERT INTO genre_film(film_id, genre_id) VALUES( $id_film, $id_genre)");
        $genre_film->execute();
        
        $acteur_film = $bdd->prepare("INSERT INTO acteurs_film(film_id, acteur_id) VALUES( $id_film, $id_acteur)");
        $acteur_film->execute();
        
        $acteur2_film = $bdd->prepare("INSERT INTO acteurs_film(film_id, acteur_id) VALUES( $id_film, $id_acteur2)");
        $acteur2_film->execute();
        
        $acteur3_film = $bdd->prepare("INSERT INTO acteurs_film(film_id, acteur_id) VALUES( $id_film, $id_acteur3)");
        $acteur3_film->execute();
        
        $realisateur_film = $bdd->prepare("INSERT INTO realisateur_film(film_id, realisateur_id) VALUES( $id_film, $id_real)");
        $realisateur_film->execute();
        
        $realisateur2_film = $bdd->prepare("INSERT INTO realisateur_film(film_id, realisateur_id) VALUES( $id_film, $id_real2)");
        $realisateur2_film->execute();
        
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////


function verifForm($pseudo, $pass, $uri1, $retour){
            // SI FORMULAIRE REMPLI 
    if(isset($_POST['pseudo']) && isset($_POST['pass'])){        
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['pass'];
        connecter($uri1, $retour, $pseudo, $pass);
        
    // SI FORMULAIRE PAS REMPLI
    }else{
        connecter($uri1, $retour, "", "");
    }
}


function connecter($uri1, $retour, $pseudo, $pass){
    require('models/model.php');      
    
    // AFFICHAGE PAGE SI FORMULAIRE REMPLI
        if($pseudo != "" && $pass != ""){
            $req = $bdd->prepare("SELECT pass FROM users WHERE pseudo = '".$pseudo."'");
            $req->execute();
            $resultat = $req->fetch();  

            
            // SI FORMULAIRE REMPLI = CORRECT
            if ($_POST['pass'] == $resultat['pass']){

                $_SESSION['pseudo'] = $pseudo;
                echo $twig->render("".$uri1.".html.twig",[
                "data" => $retour,
                "connexion" => "ok",
                "pseudo" =>  $_SESSION['pseudo'],
                "pageActuelle" => $uri1
                ]);

            // SI FORMULAIRE REMPLI = PAS BON
            } else {
                echo $twig->render("".$uri1.".html.twig",[
                "data" => $retour,
                "connexion" => "pas ok",
                "pageActuelle" => $uri1
                ]); 
            }
    }     
    // AFFICHAGE PAGE SI FORMULAIRE PAS REMPLI
    else {   
        // AFFICHAGE PAGE SI UTILISATEUR DEJA CONNECTE
        if(isset($_SESSION['pseudo'])){
            echo $twig->render("".$uri1.".html.twig",[
                "data" => $retour,
                "connexion" => "ok",
                "pseudo" =>  $_SESSION['pseudo'],
                "pageActuelle" => $uri1
            ]); 
        // AFFICHAGE PAGE SI UTILISATEUR PAS ENCORE CONNECTE
        }else{
            
                   
            echo $twig->render("".$uri1.".html.twig",["data" => $retour,
                                                      "data1" => $retour,
                                                     "pageActuelle" => $uri1] );  
        }
    }   
}



?>