<?php
require_once "includes/functions.php";
session_start();

?>


<?php 
    require_once "includes/head.php"; 
    if (empty($_GET['recherche']) == false){
        $key = escape($_GET['recherche']);
    }
    else //éviter l'erreur d'index indéfini quand l'utilisateur n'a pas encore tapé dans la barre de recherche
    {
        $key = 1; //se garantir un affichage vide, mais l'index est défini.
    }

    $bdd=getLocalDb();
    $query= $bdd->prepare('select distinct * from alumni where Promo = :thispromo');
    $query->bindValue(':thispromo', "{$key}%");
    $query->execute();
    $eleves = $query->fetchAll();

?>

<html>

<body>
  
    <?php require_once "includes/header.php"; ?>
    <br/>
    <div class="Jumbotron container content">
    <div class="topnav" ><br/>
        <h3> Entrez une promo (année de sortie): </h3>
    </div> 

    <form action = "promotions.php" method = "GET">
        <div class="sb-example-1 row justify-content-center">
            <div class="search">
                <input type="text" class="searchTerm" name="recherche" placeholder="Entrez une année de promotion" required>
                <button type="submit" class="searchButton"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form><br/>

       
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
                   <td><a href="eleve.php?id=<?= $eleve['IdAlumni'] ?>"><?= $eleve['PrenomEleve'] ?></a></td> 
                   <td><a href="eleve.php?id=<?= $eleve['IdAlumni'] ?>"><?= $eleve['NomEleve'] ?></a></td>
                
                </tr>
            <?php } ?>
            <tbody>
        </table>
        </div>

    <?php require_once "includes/footer.php"; ?>
</body>

</html>