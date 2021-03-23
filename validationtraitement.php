<html>
<?php
require_once "includes/functions.php";
include_once 'includes/head.php';
session_start();

?>

<?php if (isset($_POST["valider"])){
    $query= $bdd->prepare('update Alumni set Valide=1 WHERE Alumni.IdAlumni = :idalumni ');
    $query->bindValue(':name', "{$eleve['IdAlumni']}%");
    $query->execute();
    
    //echo 'you re going to redirect';
    redirect('validation.php');  
    }?>
           
</html>
