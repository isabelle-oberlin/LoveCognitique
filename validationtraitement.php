<?php
require_once "includes/functions.php";


    if (isset($_POST['id']))
    {
        $bdd = getLocalDb();
        $query= $bdd->prepare('update alumni set Valide=1 WHERE Alumni.IdAlumni = :idalumni ');
        $query->bindValue(':idalumni', "{$_POST['id']}%");
        $query->execute();
    }
    
    redirect('validation.php');
?>

