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
                <form class="search" action="searchbar.php" method="GET">
                    <input type="search" name="recherche" placeholder="Recherchez ici" required>
                    <button type="submit">Search</button>
                </form>   
                </div>                
            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>
