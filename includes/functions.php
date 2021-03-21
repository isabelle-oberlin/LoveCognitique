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

// Check if a user is connected
function isUserConnected() {
    return isset($_SESSION['mail']);
}

//check if an admin is connected
function isAdminConnected() {
    if(isUserConnected()){
        $query = getLocalDb()->prepare('select * from gestionnaire where Mail=:mail');
        $query->bindValue(':mail', $_SESSION['mail']);
        $query->execute();
        if ($query->rowCount() == 1) {
            return isset($_SESSION['mail']);
        }
        else {
            return false;
        }
    }
    else{
        return false;
    }
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}