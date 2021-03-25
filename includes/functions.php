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

    $query = getLocalDb()->prepare('select * from Commune where NomCommune=? and Region=? and Pays=?');
    $query->execute(array($ville, $region, $pays));
    $commune = $query->fetch();

    if(isset($commune)){
        return $commune['IdCommune'];
    }
    else{
        $requete = getLocalDb()->
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