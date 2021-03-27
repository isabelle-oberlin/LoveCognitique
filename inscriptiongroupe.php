<html>
        <?php
            session_start();
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            
        ?>

    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        <div class="content">
          <?php 
          $file = fopen('file.txt', 'r');
          //on estime que le doc a, à chaque ligne, une colonne de notre BDD 

          $bdd = getLocalDb();

          while(! feof($file))
          {
          $query= $bdd->prepare('select max(IdAlumni) from Alumni');
           $query->execute();
            $new_id = $query->fetch();
            $new_id = $new_id['max(IdAlumni)'];
            $new_id += 1;

          $stmt = $bdd->prepare('insert into Alumni (IdAlumni, NomEleve, PrenomEleve, Promo, AdressePostale, Mail, Mdp, Genre, Tel, Valide, IdCommune, IdGestionnaire) values (:IdAlumni, :NomEleve, :PrenomEleve, :Promo, :AdressePostale, :Mail, :Mdp, :Genre, :Tel, 1, :idCommune, 1)');
          $stmt->bindValue(':IdAlumni', $new_id);
          $stmt->bindValue(':NomEleve', fgets($file));
          $stmt->bindValue(':PrenomEleve', fgets($file));
          $stmt->bindValue(':Promo', fgets($file));
          $stmt->bindValue(':AdressePostale', fgets($file));
          $stmt->bindValue(':Mail', fgets($file));
          $stmt->bindValue(':Mdp', fgets($file));
          
         $query= $bdd->prepare('select Genre from Alumni where Genre= :g');
                $query->bindValue(':g', fgets($file));
                $query->execute();
                $genre=$query->fetch();
                $genre=$genre['Genre'];
                

          $stmt->bindValue(':Genre', $genre);
          $stmt->bindValue(':Tel', fgets($file));

          $cp = fgets($file);
                $query= $bdd->prepare('select IdCommune from Commune where CodePostal= :cp');
                $query->bindValue(':cp', $cp);
                $query->execute();
                $idcommune=$query->fetch();
                $idcommune=$idcommune['IdCommune'];

          $stmt->bindValue(':idCommune', $idcommune);
          $stmt->execute();
          $stmt->fetch();
        }
        //end of the while: supposedly, you begin again for the next student till you reach the eof
          ?>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>