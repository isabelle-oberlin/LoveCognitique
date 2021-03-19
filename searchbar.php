<?php
    include_once 'includes/functions.php';
    $key = escape($_GET['recherche']);
    $array = array();
    $bdd=getLocalDb();
    $query= $bdd->prepare('select distinct * from Alumni, Commune, Confidentialite where NomEleve LIKE :name or PrenomEleve LIKE :name 
    and Commune.IdCommune = Alumni.IdCommune and Alumni.IdAlumni = Confidentialite.IdAlumni');
    $query->bindValue(':name', "{$key}%");
    $query->execute();
    $results = $query->fetchAll();
?>

<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            session_start();
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
                    {?>
                    <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                    <p>Promotion : <?= $resultat['Promo'] ?> <?php if($resultat['ConfiAdresse'] == 1){?> Commune: <?php print $resultat['NomCommune']; } ?></p>
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