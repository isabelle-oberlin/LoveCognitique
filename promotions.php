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
    <div class="container">
        <?php require_once "includes/header.php"; ?>
        
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($eleves as $eleve) { ?>
                <tr>
                <th scope="row">1</th>
                    <td><?php $eleve['PrenomEleve'] ?></td>
                    <td><?php $eleve['NomEleve'] ?></td>
                </tr>
            <?php } ?>
            <tbody>
        </table>

    <?php require_once "includes/footer.php"; ?>
</div>

<?php require_once "includes/scripts.php"; ?>
</body>

</html>