<?php 

require_once "functions.php";

$bdd = get_Db();
$requetes = $bdd->query('SELECT * FROM CACA');

?>

<body>
    <?php 
        foreach($requetes as $requete)
        {
            echo $requete['GATEAU'];
        }
    ?>
</body>