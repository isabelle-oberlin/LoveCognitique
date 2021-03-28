<?php require_once "includes/functions.php"; ?>

<header>
    <div class="topimage">
        <img class="imgfluid" src="media/img/photoPatio.jpg" alt="Photo Patio de l'ENSC">
    </div>
</header>


<nav class="navbar navbar-dark bg-dark navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <?php if (isAdminConnected()) { ?>
                <a class="navbar-brand" href="indexadmin.php">Menu Administration</a>
            <?php } else { ?>
                <a class="navbar-brand" href="index.php">Menu</a>    
            <?php } ?>
        </div>

        <div class="navbar-header">
            <a class="navbar-brand" href="promotions.php"> Promotions</a>
        </div>

        <?php if (isUserConnected()) { ?>
            <div class="navbar-header">
                <a class="navbar-brand" href="monprofil.php">Mon profil</a>
            </div>
        <?php } ?>

        <div class="navbar-header">
            <?php if (isUserConnected()) { ?>
                <a class="navbar-brand" href="deconnexion.php"><?= $_SESSION['mail']?> - Se déconnecter</a>
            <?php } 
                else {
            ?>
                <a class="navbar-brand" href="connexion.php">Se connecter</a>
            <?php } ?>
        </div>
    </div><!-- /.container -->
</nav>