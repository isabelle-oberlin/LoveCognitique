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
                <h1 class="display-4">Inscription</h1>
                
                <hr class="my-4">
                <?php if(isUserConnected() == false){ ?>
                <div class="topnav">
                <form class="container" action="searchbar.php" method="GET">
                    
                </div> 
                <?php } else{ ?>
                Vous êtes déjà inscrit.e ! 
                <?php } ?>

            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>