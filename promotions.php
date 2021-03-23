<?php
require_once "includes/functions.php";
session_start();

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

     <?php
    $key = escape($_POST['recherche']);
    $bdd=getLocalDb();
    $query= $bdd->prepare('select distinct * from Alumni where Promo = :thispromo');
    $query->bindValue(':thispromo', "{$key}%");
    $query->execute();
    $eleves = $query->fetchAll();
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