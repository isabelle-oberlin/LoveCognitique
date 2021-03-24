<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            session_start();

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
            from experiences, organisations where IdAlumni=? and organisations.IdOrga = experiences.IdOrga order by DateFin desc');
            $exp->execute(array($IdAlumni));
            $experiences = $exp->fetchAll();
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        <div class="content">
            <br/>
            <div class="Jumbotron container">
                <h1 class="display-3"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve'] ?></h1>
                
                <hr class="my-4">
                <div class="justify-content-center">
                    <!-- passer en lien vers la promo -->
                        Promotion : <?= $eleve['Promo'] ?>
                        <br>

                        <?php if($confidentialite['ConfiAdresse'] || isAdminConnected()){ ?>
                        Commune : <?= $commune['NomCommune'],", ",$commune['Pays'] ?>
                        <?php } ?>

                        <?php if($confidentialite['ConfiMail']|| isAdminConnected()){ ?>
                        Mail : <?= $eleve['Mail'] ?>
                        <?php } ?><br>

                        <?php if($confidentialite['ConfiTel']|| isAdminConnected()){ ?>
                        Téléphone : +33<?= $eleve['Tel'] ?>
                        <?php } ?><br>

                        <?php if($confidentialite['ConfiGenre']|| isAdminConnected()){ ?>
                        Genre : <?= $eleve['Genre'] ?>
                        <?php } ?><br>
                </div>    
                <br>

                <h1 class="display-4">Expériences</h1>
                <hr class="my-4">
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
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>