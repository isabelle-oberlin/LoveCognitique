<?php
require_once "includes/functions.php";
session_start();

if (!empty($_POST['login']) and !empty($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $stmt = getDb()->prepare('select * from user where usr_login=? and usr_password=?');
    $stmt->execute(array($login, $password));
    if ($stmt->rowCount() == 1) {
        // L'utilisateur existe bien et s'est connecté
        $_SESSION['login'] = $login;
        redirect("index.php");
    }
    else {
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
    
    
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger">
            <strong>Erreur !</strong> <?= $error ?>
        </div>
    <?php } ?>
    </br>

        <div class="row">
            <div class="col-md-3 col-sm-1"> </div> 
            <div class="col-md-6 col-sm-10"> 
                <div class="form-container">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <span class="input-icon"><i class="fa fa-user"></i></span>
                            <input class="form-control" type="text" placeholder="Identifiant">
                        </div>
                        <div class="form-group">
                            <span class="input-icon"><i class="fa fa-lock"></i></span>
                            <input class="form-control" type="password" placeholder="Password">
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
<h3 class="text-center" >Pas encore de compte ?  <u href = "creationcompte.php">Créez-en un ici </u></h3> 
</div>

<?php
            include_once 'includes/footer.php';
        ?>
</body>
</html>