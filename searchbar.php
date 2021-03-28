<?php
    include_once 'includes/functions.php';
   
    session_start();
    $key = escape($_GET['recherche']);
    $array = array();
    $bdd=getLocalDb();

    //Prepare la requete selon le type de demande
    $type = $_GET['searchType'];
    switch($type)
    {
        case "eleve":
            $query= $bdd->prepare('select distinct * from alumni, confidentialite, commune where NomEleve like :key or PrenomEleve like :key and confidentialite.IdAlumni=alumni.IdAlumni and commune.IdCommune=alumni.IdCommune');
            break;
        
        case "secteur":
            $query= $bdd->prepare('select distinct * from experiences, alumni, organisations, commune, secteur, categorise where NomSecteur like :key and alumni.IdAlumni=experiences.IdAlumni and organisations.IdOrga=experiences.IdOrga and commune.IdCommune=organisations.IdCommune and categorise.IdSecteur=secteur.IdSecteur and experiences.IdExp=categorise.IdExp');
            break;
        
        case "type":
            $query= $bdd->prepare('select distinct * from experiences, alumni, organisations, commune where TypeExp like :key and alumni.IdAlumni=experiences.IdAlumni and organisations.IdOrga=experiences.IdOrga and commune.IdCommune=organisations.IdCommune');
            break;
        
        case "region":
            $query= $bdd->prepare('select distinct * from experiences, organisations, commune, alumni where organisations.IdCommune = commune.IdCommune and experiences.IdOrga = organisations.IdOrga and alumni.IdAlumni = experiences.IdAlumni and commune.Region like :key');  
            break;
            
        case "poste":
            $query = $bdd->prepare('select distinct * from experiences, poste, alumni, organisations, commune where NomPoste like :key and alumni.IdAlumni=experiences.IdAlumni and organisations.IdOrga=experiences.IdOrga and commune.IdCommune=organisations.IdCommune and experiences.IdPoste=poste.IdPoste');
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
                    //affichages distingués
                    foreach($results as $resultat)
                    {
                    switch($type)
                    {
                        case "eleve":?>
                            <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                            <p>Promotion : <?= $resultat['Promo'] ?> <?php if($resultat['ConfiAdresse'] == 1){?> Commune: <?php print $resultat['NomCommune']; } ?></p>
                        <?php    break;
                        case "region":  ?>
                        <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                            <p class="lead"> <?= $resultat['NomCommune'], ", ", $resultat['Region']?> </p> 
                            <p class="lead"> <?= "Description : ", $resultat['Description']  ?> </p> <?php
                            break;

                        case "secteur": ?>
                        <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                            <p class="lead"> <?= $resultat['NomSecteur'], ". ", $resultat['Region'], ", ", $resultat['NomCommune']?> </p> 
                            <p class="lead"> <?= "Description : ", $resultat['Description']  ?> </p> <?php
                            break;
                        
                        case "type": ?>
                        <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                        <p class="lead"> <?= $resultat['TypeExp'], ". ", $resultat['Region'], ", ", $resultat['NomCommune']?> </p> 
                        <p class="lead"> <?= "Description : ", $resultat['Description']  ?> </p> <?php
                            break;

                        case "poste": ?>
                        <p class="lead"><a href="eleve.php?id=<?= $resultat['IdAlumni'] ?>"><?= $resultat['PrenomEleve']," ",$resultat['NomEleve'] ?></a></p>
                        <p class="lead"> <?= $resultat['NomPoste'], ". ", $resultat['Region'], ", ", $resultat['NomCommune']?> </p> 
                        <p class="lead"> <?= "Description : ", $resultat['Description']  ?> </p> <?php
                            break;
                        
                    }?>
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