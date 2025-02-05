<?php 
session_start();
?>
<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
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


                <!-- barre de recherche multifonction -->
                <form class="container" action="searchbar.php" method="GET">
                Vous recherchez un.e :
                    <label for="Eleve">
                        <input type="radio" name="searchType" value="eleve" checked> Elève
                    </label>

                    <label for="secteur">
                        <input type="radio" name="searchType" value="secteur"> Expérience par secteur d'activités
                    </label>

                    <label for="type">
                        <input type="radio" name="searchType" value="type"> Type d'expérience (Stage, emploi, césure ...)
                    </label>

                    <label for="region">
                        <input type="radio" name="searchType" value="region"> Région
                    </label>
                    
                    <label for="poste">
                        <input type="radio" name="searchType" value="poste"> Poste
                    </label>

                
                    <div class="sb-example-1 row justify-content-center">
                        <div class="search">

                            <input type="text" class="searchTerm" name="recherche" placeholder="Que cherchez vous ?" required>
                            <button type="submit" class="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                            
                        </div>
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
