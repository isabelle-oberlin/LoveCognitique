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
                    <div class="form-container">
                            <form class="form-horizontal" method = "POST" action = "inscription.php">

                                <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Nom" type="text" placeholder="Nom">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Prenom" type="text" placeholder="Prenom">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Promo" type="text" placeholder="Année de sortie">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="Adresse" type="text" placeholder="Adresse">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Mail" type="mail" placeholder="Mail">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Mot de passe" type="password" placeholder="Mot de passe">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Tel" type="text" placeholder="Tel">
                                </div>

                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input type="radio" name="genre" value="Homme"> Homme 
                                    <input type="radio" name="genre" value="Femme"> Femme 
                                    <input type="radio" name="genre" value="NB"> NB   
                                </div>
                                


                                <button class="btn signin">Allons-y !</button>
                                
                                <span class="forgot-pass">Vous recevrez une confirmation de notre administrateur. Patience d'ici là ;)</span>
                            </form>
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