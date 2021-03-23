<html>
  <?php 
    include_once 'includes/head.php';
    include_once 'includes/functions.php';
    session_start();
  ?>
    
<body>
    <?php include_once 'includes/header.php';?>
    <br/>
    <div class="jumbotron container content">
    <?php if(isAdminConnected()) {?>
    
      <h1 class="display-5"><a href = "validation.php">Valider les comptes d'élèves en attente </a></h1>
      <p class="lead">Accès à la liste de comptes en attente. Rendez-les fonctionnels pour que les élèves puissent se connecter!</p>
      <h1 class="display-5"><a href = "inscription.php">Créer un compte élève</a></h1>
      <p class="lead">Créer un compte à un élève. Vous pourrez ensuite lui transmettre les informations de connexion.</p>
      <h1 class="display-3"><a href = "inscriptiongroupe.php">Créer un compte à un groupes d'élèves à partir d'un fichier</a></h1>
      <p class="lead"> Créer de façon automatisée les comptes d'un groupe d'élève à partir d'une liste.</p>
      <h1 class="display-5"><a href = "adminstat.php">Statistiques</a></h1>
      <p class="lead">Accès aux statistiques sur les comptes des élèves et l'évolution de ce site.</p>
      <h1 class="display-5"><a href="promotions.php"> Consultation des comptes</a></h1>
      <p class="lead">Accès aux statistiques sur les comptes des élèves et l'évolution de ce site.</p>
 
   
   <!-- FIXME: consultation des comptes DONT ELETS PRIVES. donc promo affichage sans s'arrêter au bool private-->
  
    </div>
    <?php 
      } else {
    ?>

    <h1 class="display-1">VOUS N'ÊTES PAS ADMIN MANANT</h1>

    <?php 
      } 
      include_once 'includes/footer.php';
    ?>   
</body>

</html>
