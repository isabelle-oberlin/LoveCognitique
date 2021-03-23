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
                <?php if(isUserConnected() == false || isAdminConnected() == true){ ?>
                    <div class="form-container">
                            <form class="form-horizontal" method ="POST" action ="traitementInsciption.php">

                                <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>

                                <fieldset class="borderline-clear">
                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Nom" type="text" placeholder="Nom" required> 
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Prenom" type="text" placeholder="Prenom" required> 
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Promo" type="text" placeholder="Année de sortie" required>
                                </div>
                                </fieldset>     
                                    
                                <fieldset class="borderline-pink">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="confiadresse" name="confiadresse">
                                    <label class="custom-control-label" for="confiadresse">Rendre ces informations visibles à tous les éléves</label>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="Adresse" type="text" placeholder="Adresse">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="cp" type="text" placeholder="Code Postal">
                                </div>
                                </fieldset> 
                                
                                <fieldset class="borderline-pink">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="confimail" name="confimail">
                                    <label class="custom-control-label" for="confimail">Rendre cette information visible à tous les éléves</label>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Mail" type="mail" placeholder="Mail" required>
                                </div>
                                </fieldset>   
                                    
                                <fieldset class="borderline-clear">
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="motdepasse" type="password" placeholder="Mot de passe" required>
                                </div>
                                </fieldset> 
                                
                                <fieldset class="borderline-pink">    
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="confitel" name="confitel">
                                    <label class="custom-control-label" for="confitel">Rendre cette information visible à tous les éléves</label>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Tel" type="text" placeholder="Tel">
                                </div>
                                </fieldset> 
                                
                                <fieldset class="borderline-pink">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="configenre" name="configenre">
                                    <label class="custom-control-label" for="configenre">Rendre cette information visible à tous les éléves</label>
                                </div>
                                <div class="" >
                                    
                                    <input type="radio" name="genre" value="H" required> Homme 
                                    <input type="radio" name="genre" value="F"> Femme 
                                    <input type="radio" name="genre" value="NB" checked> NB   
                                </div>
                                </fieldset> 
                                
                                <button type="submit" class="btn signin">Allons-y !</button>
                                
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