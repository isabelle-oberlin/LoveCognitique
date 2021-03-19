<?php
require_once "includes/functions.php";
session_start();

/*$eleveId = $_GET['Mail'];
$promo = getDb()->prepare('select * from Alumni where Promo=?');
$promo->execute(array($eleveId));
$eleve = $promo->fetch();*/

$eleves = getLocalDb()->query('SELECT * from Alumni'); 

?>


<?php 
require_once "includes/head.php"; 
?>
<!doctype html>
<html>

<body>
  
    <?php require_once "includes/header.php"; ?>

    <div class="container content">
    <div class="topnav" >
        <h3> Entrez une promo (année de sortie): </h3>
    </div> 

    <form action = "promotions.php" method = "POST">
        <div class="sb-example-1 row justify-content-center">
            <div class="search">
                <input type="text" class="searchTerm" name="recherche" placeholder="Entrez une année de promotion" required>
                <button type="submit" class="searchButton"><i class="fa fa-search"></i></button>
            </div>
        </div>
     </form>

    <?php if (empty($_POST['promo']) == false)
            {   
                $annee = $_POST['promo'];
                $eleves = getLocalDb()->query('SELECT * from Alumni where promo= $annee'); 
            }
            ?>

        
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