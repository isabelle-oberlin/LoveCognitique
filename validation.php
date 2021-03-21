<html>
<?php 
include_once 'includes/head.php';
include_once 'includes/functions.php';
session_start();

$bdd = getLocalDb();
$query= $bdd->prepare('select * from Alumni where Valide = 0');
$query->execute();
$eleves = $query->fetchAll();

//UPDATE `Alumni` SET `Valide` = '1' WHERE `Alumni`.`IdAlumni` = 4 
?>

<body>
<?php include_once 'includes/header.php';?>
<div class="content">
<br/>
            <div class="Jumbotron container">
                <h1 class="display-4">Comptes élèves en attente de validation </h1>
                <hr class="my-4">
                  <?php
                    foreach($eleves as $eleve)
                    {?>
                    <p class="lead"><a href="eleve.php?id=<?= $eleve['IdAlumni'] ?>"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve'] ?></a></p>
                    <p>Promotion : <?= $eleve['Promo'] ?></p> 
                    <p> Adresse: <?php print $eleve['AdressePostale'];  ?></p> 
                    <p>Mot de passe: <?= $eleve['Mdp'] ?> </p> 
                    <button type="submit" id="valider" class="btn btn-secondary active" aria-pressed="true">Valider ce compte</button>

                    <!-- si l'admin clique sur valider pour cet élève
                    <?php if (isset($_POST["valider"])){
                        $query= $bdd->prepare('update Alumni set Valide=1 WHERE Alumni.IdAlumni = :idalumni ');
                        $query->bindValue(':name', "{$eleve['IdAlumni']}%");
                        $query->execute();
                        }?>
                    
                    <?php }

                  ?>
                </div>                
            </div>
</div>
</body>

</html>
