<html>
<?php 
include_once 'includes/head.php';
include_once 'includes/functions.php';
session_start();
?>
    
<body>
    <?php include_once 'includes/header.php';?>
    <div class="content">
    <div class="jumbotron">
  <h1 class="display-3"><a href = "validation.php">Valider les comptes d'élèves en attente </a></h1>
  <p class="lead">Accès à la liste de comptes en attente. Rendez-les fonctionnels pour que les élèves puissent se connecter!</p>
  <h1 class="display-3"><a href = "adminstat.php">Statistiques</a></h1>
  <p class="lead">Accès aux statistiques sur les comptes des élèves et l'évolution de ce site.</p>
  <h1 class="display-3"><a href="promotions.php"> Consultation des comptes</a></h1>
  <p class="lead">Accès aux statistiques sur les comptes des élèves et l'évolution de ce site.</p>
 
   
   <!-- FIXME: consultation des comptes DONT ELETS PRIVES. donc promo affichage sans s'arrêter au bool private-->
  
    </div>
</body>

</html>
