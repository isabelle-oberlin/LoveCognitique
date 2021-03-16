<?php
    include_once 'includes/functions.php';
    $key = escape($_GET['key']);
    $array = array();
    $bdd=getDb();
    $query= $bdd->prepare('select * from Alumni where NomEleve LIKE %? or PrenomEleve LIKE %?');
    $query->execute(array($key, $key));
    while($row=$query->fetch(PDO::FETCH_ASSOC))
    {
      $array[] = $row['title'];
    }
    echo json_encode($array);
    mysqli_close($con);
?>

