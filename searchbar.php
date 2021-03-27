<?php
    include_once 'includes/functions.php';
   
    session_start();
    $key = escape($_GET['recherche']);
    $array = array();
    $bdd=getLocalDb();

    $type = $_GET['searchType'];
    switch($type)
    {
        case "eleve":
            $query= $bdd->prepare('select distinct * from alumni, confidentialite, commune where NomEleve like :key or PrenomEleve like :key and confidentialite.IdAlumni=alumni.IdAlumni and commune.IdCommune=alumni.IdCommune');
            break;
        
        case "secteur":
            $query= $bdd->prepare('select distinct * from experiences, secteur, categorise where experiences.IdExp = categorise.IdExp and secteur.IdSecteur = categorise.IdSecteur and NomSecteur like :key');
            break;
        
        case "type":
            $query= $bdd->prepare('select distinct * from experiences where TypeExp like :key');
            break;
        
        case "region":
            $query= $bdd->prepare('select distinct * from experiences, organisations, commune where organisations.IdCommune = commune.IdCommune and experiences.IdOrga = organisations.IdOrga and commune.Region like :key');  
            break;   
    }

    $query->bindValue(':key', "{$key}%");
    $query->execute();
    $results = $query->fetchAll();
     
?>

<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        <div class="content">
            <br/>
            <div class="Jumbotron container">
                <h1 class="display-4">Résultats de la recherche pour <?= $key ?></h1>
                <hr class="my-4">
                  <?php

                    foreach($results as $resultat)
                    {
                    switch($type)
                    {
                        case "eleve":?>
                            <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                            <p>Promotion : <?= $resultat['Promo'] ?> <?php if($resultat['ConfiAdresse'] == 1){?> Commune: <?php print $resultat['NomCommune']; } ?></p>
                        <?php    break;
                        case "secteur": ?>
                        <!-- PAS FINI L AFFICHAGE: S ADAPTER AUX DIFFERENTS CASES -->

                            <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                            <p>Promotion : <?= $resultat['Promo'] ?> <?php if($resultat['ConfiAdresse'] == 1){?> Commune: <?php print $resultat['NomCommune']; } ?></p>
<?
                            break;

                        case "type":
                            break;
                        
                        case "region":
                            break;
                    }
                    ?>
                    <?php }

                  ?>
                </div>                
            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>