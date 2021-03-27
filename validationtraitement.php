<?php
require_once "includes/functions.php";


    if (isset($_POST['id']))
    {
        $bdd = getLocalDb();
        $query= $bdd->prepare('update alumni set Valide=1 WHERE alumni.IdAlumni = :idalumni ');
        $query->bindValue(':idalumni', "{$_POST['id']}");
        $query->execute();
    }
    
    redirect('validation.php');
?>

