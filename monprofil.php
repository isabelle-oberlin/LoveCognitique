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
            }
          
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        
            <?php if (!isAdminConnected())
            {?>
            <div class=" content">
            <div class="Jumbotron container">
                <br>
                <h3 class="display-4"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve'] ?></h3>
                <p class="lead">Promo: <?= $eleve['Promo']?></p>
                <p class="lead">Adresse: <?= $eleve['AdressePostale']?></p>
                <p class="lead">Téléphone: <?= $eleve['Tel']?></p>
                <p class="lead">Genre: <?= $eleve['Genre']?></p>
                <hr class="my-2">
                <p>Vous pouvez laisser votre numéro de téléphone ou votre mail en public, pour que les nouvelles générations vous demandent des conseils ;) Faites-leur profiter de votre expérience !</p>
                </div> 
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