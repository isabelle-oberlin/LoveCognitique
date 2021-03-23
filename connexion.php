<?php
require_once "includes/functions.php";
session_start();

if (!empty($_POST['mail']) and !empty($_POST['password'])) {
    $mail = escape($_POST['mail']);
    $password = escape($_POST['password']);
    $stmt = getLocalDb()->prepare('select * from alumni where Mail=? and Mdp=?');
    $stmt->execute(array($mail, $password));
    if ($stmt->rowCount() == 1) {
        // L'utilisateur existe bien et s'est connecté
        $_SESSION['mail'] = $mail;
        redirect('index.php');
    }
    else {
        $stmt = getLocalDb()->prepare('select * from gestionnaire where Mail=? and Mdp=?');
        $stmt->execute(array($mail, $password));
        if ($stmt->rowCount() == 1) {
        // L'administrateur existe bien et s'est connecté
        $_SESSION['mail'] = $mail;
        redirect("indexadmin.php");
    }
        $error = "Utilisateur non reconnu";
    }
}
?>

<html>

<?php require_once "includes/head.php";?>

<body>

    <?php require_once "includes/header.php"; ?>

    <div class="container content">
    </br>
    <h2 class="text-center">Se connecter</h2>
    
    
            </br>

                <div class="row">
                    <div class="col-md-3 col-sm-1"> </div> 
                    <div class="col-md-6 col-sm-10"> 
                        <div class="form-container">
                            <form class="form-horizontal" method = "POST" action = "connexion.php">

                                <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group" >
                                    <i class="fas fa-user input-icon"></i>
                                    <input class="form-control" name="mail" type="text" placeholder="Mail">
                                </div>
                                <div class="form-group">
                                    <i class="fas fa-lock  input-icon"></i>
                                    <input class="form-control" name="password" type="password" placeholder="Mdp">
                                </div>
                                <button class="btn signin">Allons-y !</button>
                                <div class="remember-me">
                                    <input type="checkbox">
                                    <label>Rester connecté</label>
                                </div>
                                <span class="forgot-pass">Vous avez oublié votre mot de passe? <a href="#"><u>Cliquez ici</u></a></span>
                            </form>
                        </div>
                    </div> 
                    <div class="col-md-3 col-sm-1"> </div> 
                </div>

            </br>
        <h3 class="text-center">Pas encore de compte ?  <a href = "inscription.php">Créez-en un ici </a></h3> 
    </div>

<?php include_once 'includes/footer.php'; ?>
</body>
</html>