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

    $query = $bdd->prepare('select * from Commune where lower(NomCommune)=? and lower(Region)=? and lower(Pays)=?');
    $query->execute(array($ville, $region, $pays));
    $commune = $query->fetch();

    if($query->rowCount() == 1){
        return $commune['IdCommune'];
    }
    else{
        $max = $bdd->prepare('select max(IdCommune) from Commune');
        $max->execute();
        $new_id = $max->fetch();
        $new_id = $new_id['max(IdCommune)'] + 1;

        $requete = $bdd->prepare('insert into Commune (IdCommune, NomCommune, Region, Pays) values (?,?,?,?)');
        $requete->execute(array($new_id, $ville, $region, $pays));
        return $new_id;
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