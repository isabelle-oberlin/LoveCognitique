<?php

// Connect to the database. Returns a PDO object
function getDb() {
    // Local deployment
    /* $server = "localhost";
    $username = "mymovies_user";
    $password = "secret";
    $db = "mymovies"; */
    
    // Deployment on Heroku with ClearDB for MySQL
    //$url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    //MYSQL distant
    $server = "10.185.0.92";
    $username = "lovevwng_admin";
    $password = "EncoreUneBDD!123";
    $db = "lovevwng_BDD";

    
    
    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

// Check if a user is connected
function isUserConnected() {
    return isset($_SESSION['login']);
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
}

// Escape a value to prevent XSS attacks
function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}