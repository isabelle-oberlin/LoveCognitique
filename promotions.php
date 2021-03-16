<?php
require_once "includes/functions.php";
session_start();

/*$eleveId = $_GET['Mail'];
$promo = getDb()->prepare('select * from Alumni where Promo=?');
$promo->execute(array($eleveId));
$eleve = $promo->fetch();*/

$eleves = getDb()->query('SELECT * from Alumni'); 

?>


<?php 
require_once "includes/head.php"; 
?>
<!doctype html>
<html>

<body>
  
    <?php require_once "includes/header.php"; ?>

    
    <div class="topnav" >
        <h3> Entrez une promo (année de sortie): </h3>
        <form action = "promotions.php" method = "POST">
       
        <div class="form-group" >
            <i class="fas fa-user input-icon"></i>
            <input class="form-control" type="text" name="promo" placeholder="Promo">
            <i input id = "submit" class = "fas fa-search" type = "submit" value="Chercher">
        </div>
    </div> 

    <?php if (empty($_POST['promo']) == false)
            {   
                $annee = $_POST['promo'];
                $eleves = getDb()->query('SELECT * from Alumni where promo= $annee'); 
            }
            ?>

        <div class="container content">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $i = 1;
                foreach ($eleves as $eleve) {     
            ?>
                <tr>
                
                <th scope="row"><?= $i++; ?></th>
                   <td><?= $eleve['PrenomEleve'] ?></td> 
                    <td><?= $eleve['NomEleve'] ?></td>
                </tr>
            <?php } ?>
            <tbody>
        </table>
        </div>

    <?php require_once "includes/footer.php"; ?>
</body>

</html>