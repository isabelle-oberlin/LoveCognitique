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
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        <div class="content">
            <br/>
            <div class="Jumbotron container">
                <h1 class="display-4"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve'] ?></h1>
                
                <hr class="my-4">
                <div class="topnav">
                    <!-- passer en lien vers la promo -->
                        Promotion : <?= $eleve['Promo'] ?>
                        <?php if()
                        Mail : <?= $eleve['Mail'] ?>
                        Téléphone : +33<?= $eleve['Tel'] ?>
                        Genre : <?= $eleve['Genre'] ?>
                </div>                
            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>