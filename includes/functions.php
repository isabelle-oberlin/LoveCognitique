<?php

// Connect to the database. Returns a PDO object
function getDb() {
    

    $server = "10.185.0.92";
    $username = "lovevwng_admin";
    $password = "EncoreUneBDD!123";
    $db = "lovevwng_BDD";

    
    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

function getLocalDb() {
    

    $server = "localhost";
    $username = "lovevwng_admin";
    $password = "EncoreUneBDD!123";
    $db = "lovevwng_BDD";

    
    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

function getSetCommune($ville, $region, $pays){

    $bdd = getLocalDb();

    $query = $bdd->prepare('select * from commune where lower(NomCommune)=? and lower(Region)=? and lower(Pays)=?');
    $query->execute(array($ville, $region, $pays));
    $commune = $query->fetch();

    if($query->rowCount() == 1){
        return $commune['IdCommune'];
    }
    else{
        $max = $bdd->prepare('select max(IdCommune) from commune');
        $max->execute();
        $new_id = $max->fetch();
        $new_id = $new_id['max(IdCommune)'] + 1;

        $requete = $bdd->prepare('insert into commune (IdCommune, NomCommune, Region, Pays) values (?,?,?,?)');
        $requete->execute(array($new_id, $ville, $region, $pays));
        return $new_id;
    }
}

function getSetOrganisation($nom, $typeOrga, $ville, $region, $pays){
    
    $bdd = getLocalDb();
    $idCommune = getSetCommune($ville, $region, $pays);
    $query = $bdd->prepare('select * from organisations, commune where NomOrga=? and orgainisations.IdCommune=? and commune.IdCommune = orgainisations.IdCommune');
    $query->execute(array($nom, $idCommune));
    $orga = $query->fetch();

    if($query->rowCount() == 1){
        return $commune['IdOrga'];
    }
    else{
        $max = $bdd->prepare('select max(IdOrga) from organisations');
        $max->execute();
        $new_id = $max->fetch();
        $new_id = $new_id['max(IdOrga)'] + 1;

        $requete = $bdd->prepare('insert into organisations (IdOrga, NomOrga, TypeOrga, IdCommune) values (?,?,?,?)');
        $requete->execute(array($new_id, $nom, $typeOrga, $idCommune));
        return $new_id;
    }
}

function getSecteurs($IdExp){
    $get = getLocalDb()->prepare('select Secteur.IdSecteur, NomSecteur from experiences, categorise, secteur 
    where experiences.IdExp=? and categorise.IdExp = experiences.IdExp and secteur.IdSecteur = categorise.IdSecteur order by NomSecteur ASC');
    $get->execute(array($IdExp));
    $secteurs = $get->fetchAll();
    if($get->rowCount()!= 0){ return $secteurs; }
    else{ return null; }
}

function selectSecteur(){
        $query = getLocalDb()->query('select * from secteur');
        $secteurs = $query->fetchAll();
    
        foreach($secteurs as $secteur){
            $IdSecteur = $secteur['IdSecteur'];
            $NomSecteur = $secteur['NomSecteur'];
            print "<option value=\"$IdSecteur\">$NomSecteur</option>";
        }
}

function selectPoste(){
        $query = getLocalDb()->query('select * from poste');
        $postes = $query->fetchAll();
    
        foreach($postes as $poste){
            $IdPoste = $poste['IdPoste'];
            $NomPoste = $poste['NomPoste'];
            print "<option value=\"$IdPoste\">$NomPoste</option>";
        }
}

// Check if a user is connected
function isUserConnected() {
    return isset($_SESSION['mail']);
}

//check if an admin is connected
function isAdminConnected() {
    return isset($_SESSION['status']);
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}