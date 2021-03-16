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