<?php
    include_once 'includes/functions.php';
    $key = escape($_GET['recherche']);
    $array = array();
    $bdd=getLocalDb();
    //on pourra rajouter or Experience.Type = 'stage' ...
    $query= $bdd->prepare('select distinct * from Alumni, Commune, Confidentialite, Experiences, Organisations where NomEleve LIKE :name or PrenomEleve LIKE :name or Commune.NomCommune = :commune 
    and Commune.IdCommune = Alumni.IdCommune and Alumni.IdAlumni = Confidentialite.IdAlumni and Experiences.IdOrga = Organisations.IdOrga and Organisations.IdCommune = Commune.IdCommune');
    $query->bindValue(':name', "{$key}%");
    //FIXME pour l'instant on ne change pas la requête suivant le bouton radio coché en fait... ça ne change rien XD
    $query->bindValue(':commune', "{$key}%");
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