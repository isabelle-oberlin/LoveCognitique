<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            session_start();

            //cas admin
            if (!isAdminConnected())
            {
                $mailAlumni = $_SESSION['mail']; 
                $requete = getLocalDb()->prepare('select * from Alumni where mail =:mailA');
                $requete->bindValue(':mailA', "{$mailAlumni}");
                $requete->execute();
                $eleve = $requete->fetch();
                
                $com = getLocalDb()->prepare('select * from commune where IdCommune=?');
                $com->execute(array($eleve['IdCommune']));
                $commune = $com->fetch();

                $exp = getLocalDb()->prepare('select *, DATE_FORMAT(DateDeb, "%d/%m/%Y") as DateDebFr, DATE_FORMAT(DateFin, "%d/%m/%Y") as DateFinFr 
                from experiences, organisations where IdAlumni=? and organisations.IdOrga = experiences.IdOrga order by DateFin desc');
                $exp->execute(array($eleve['IdAlumni']));
                $experiences = $exp->fetchAll();
            }
          
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        
            <?php if (!isAdminConnected())
            {?>
        <br>
            <div class=" content">
            <div class="Jumbotron container">
                <h3 class="display-4"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve'] ?></h3>
                <hr class="my-4">
                
                Promotion : <?= $eleve['Promo'] ?><br>
                Commune : <?= $commune['NomCommune'], ", ", $commune['Pays'] ?><br>
                Mail : <?= $eleve['Mail'] ?><br>
                Téléphone : +33<?= $eleve['Tel'] ?><br>
                Genre : <?= $eleve['Genre'] ?>
                        
                <hr class="my-2">
                <p>Vous pouvez laisser votre numéro de téléphone ou votre mail en public, pour que les nouvelles générations vous demandent des conseils ;) Faites-leur profiter de votre expérience !</p>
                <hr class="my-2">
                <?php foreach($experiences as $experience){ ?>
                    <div class="exp">
                        <span class="bold">
                        <?= $experience['TypeExp']," -" ?>
                        <?= $experience['NomOrga'] ?><br></span>
                        <?= "Du ",$experience['DateDebFr']," au ",$experience['DateFinFr'] ?> 
                        <br><br>
                        <?= $experience['Description'] ?>
                    </div>
                    <hr class="my-4">              
                <?php } ?>
                </div> 
                </div>
                
            

                <?php } else {?>
                <br>
                <div class=" content">
                    <div class="Jumbotron container">
                    <h3 class="display-4">Vous êtes administrateur, vous n'avez pas de profil particulier sur le site :)</h3>
                    </div>
                    </div>
                <?php } ?>
        
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>