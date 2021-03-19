<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            session_start();

            $IdAlumni = $_GET['id'];
            $requete = getLocalDb()->prepare('select * from alumni where IdAlumni=?');
            $requete->execute(array($IdAlumni));
            $eleve = $requete->fetch();
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
                  

                </div>                
            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>