<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        
            require_once 'includes/functions.php';
        
            $bdd = getDb();
        $requetes = $bdd->query('SELECT * FROM CACA');
        foreach($requetes as $requete)
        {
            echo $requete['GATEAU'];
        }
        
        
        
        ?>
    Lolo
    </body>
</html>
