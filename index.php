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
                <h1 class="display-4">L'annuaire des anciens de l'ENSC</h1>
                <p class="lead">Ceci est un joli site web avec un dégradé pour présenter l'annuaire des anciens</p>
                <hr class="my-4">
                <div class="topnav">
                <form class="container" action="searchbar.php" method="GET">
                    
                    <div class="search">
                        <input type="text" name="recherche" class="searchTerm" placeholder="Que cherchez-vous ?" required>
                        <button type="submit" class="searchButton">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                </form>   
                </div>                
            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>
