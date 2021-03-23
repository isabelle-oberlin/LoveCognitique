<?php
require_once "includes/functions.php";
session_start();


    if (isset($_POST['id']))
    {
    $bdd = getLocalDb();
    $query= $bdd->prepare('update Alumni set Valide=1 WHERE Alumni.IdAlumni = :idalumni ');
    $query->bindValue(':idalumni', "{$_POST['id']}%");
    $query->execute();
    }
    
    redirect('validation.php');
?>

