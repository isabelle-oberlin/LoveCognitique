<?php require_once "includes/functions.php"; ?>

<header>
    <div class="topimage">
        <img class="imgfluid" src="media/img/photoPatio.jpg" alt="Photo Patio de l'ENSC">
    </div>
</header>


<nav class="navbar navbar-dark bg-dark navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php"> Menu</a>
        </div>

        <div class="navbar-header">
            <a class="navbar-brand" href="promotions.php"> Promotions</a>
        </div>

        <div class="navbar-header">
            <?php if (isUserConnected()) { ?>
                <ul class="nav navbar-nav">
                    <li><a href="monprofil.php">Mon profil</a></li>
                </ul>
            <?php } else { ?>
                <ul class = "nav navbar-nav">
                    <li><a class="navbar-brand" href="connexion.php">Connexion</a></li>
                </ul>
            <?php } ?>

            <ul class="nav navbar-nav navbar-right">
                <?php if (isUserConnected()) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> Bienvenue, <?= $_SESSION['login'] ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php">Se déconnecter</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div><!-- /.container -->
</nav>