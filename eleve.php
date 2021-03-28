<?php 
session_start();
?>
<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            

            $IdAlumni = $_GET['id'];
            $requete = getLocalDb()->prepare('select * from alumni where IdAlumni=?');
            $requete->execute(array($IdAlumni));
            $eleve = $requete->fetch();

            $conf = getLocalDb()->prepare('select * from confidentialite where IdAlumni=?');
            $conf->execute(array($IdAlumni));
            $confidentialite = $conf->fetch();

            $com = getLocalDb()->prepare('select * from commune where IdCommune=?');
            $com->execute(array($eleve['IdCommune']));
            $commune = $com->fetch();

            $exp = getLocalDb()->prepare('select *, DATE_FORMAT(DateDeb, "%d/%m/%Y") as DateDebFr, DATE_FORMAT(DateFin, "%d/%m/%Y") as DateFinFr 
                from experiences, organisations, poste, commune 
                where IdAlumni=? and organisations.IdOrga = experiences.IdOrga and poste.IdPoste = experiences.IdPoste and commune.IdCommune=organisations.IdCommune order by DateFin desc');
                $exp->execute(array($eleve['IdAlumni']));
                $experiences = $exp->fetchAll();
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        <div class="content">
            <br/>
            <div class="Jumbotron container">
                <h1 class="display-3"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve']," - Promotion : ", $eleve['Promo'] ?></h1>
                
                <hr class="my-4">
                <div class="justify-content-center">
                    <!-- passer en lien vers la promo -->

                    <span class="bold">
                        <?php if($confidentialite['ConfiAdresse'] || isAdminConnected()){ ?>
                        Commune : <?= $commune['NomCommune'], ", ",$commune['Region'], ", ", $commune['Pays'] ?></br>
                        <?php } ?>

                        <?php if($confidentialite['ConfiMail']|| isAdminConnected()){ ?>
                        Mail : <?= $eleve['Mail'] ?></br>
                        <?php } ?>

                        <?php if($confidentialite['ConfiTel']|| isAdminConnected()){ ?>
                        Téléphone : <?= $eleve['Tel'] ?></br>
                        <?php } ?>

                        <?php if($confidentialite['ConfiGenre']|| isAdminConnected()){ ?>
                        Genre : <?= $eleve['Genre'] ?></br>
                        <?php } ?>
                    </span>
                </div>    
                </br>

                <h1 class="display-4">Expériences</h1>
                <hr class="my-4">
                <?php foreach($experiences as $experience){ ?>
                    <div class="exp">
                        <span class="bold">
                        <?= $experience['TypeExp']," -" ?>
                        <?= $experience['NomOrga'] ?></span>
                        
                        <br>
                        <?php if(isset($experience['NomPoste'])){ 
                            echo "Poste : ",$experience['NomPoste'],"<br>";
                        }
                        $listesecteur = getSecteurs($experience['IdExp']);
                        if(isset($listesecteur)){
                            echo "Secteur.s : ";
                            foreach (getSecteurs($experience['IdExp']) as $sect){ print $sect['NomSecteur'].' '; }
                            echo'<br>';
                        }
                        ?> 
                        <?php if($experience['DateFinFr'] == '0000-00-00'){ 
                            echo "Du ",$experience['DateDebFr']," au ",$experience['DateFinFr'],'<br>';
                        }
                        else {
                            echo "Depuis le ",$experience['DateDebFr'],'<br>';
                        }
                        ?> 
                        <?= $experience['NomCommune'], ", ",$experience['Region'], ", ", $experience['Pays'] ?>
                        <br><br>
                        <?= $experience['Description'] ?>
                        <br> 
                    </div>
                    <hr class="my-4">            
                <?php } ?>
            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>