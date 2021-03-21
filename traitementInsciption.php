<html>
        <?php
            include_once 'includes/functions.php';
            session_start();
        
            
            //formulaire et création du compte. L'administrateur changera simplement le bool "validé"; 
            //pour l'instant on peut créer un compte avec juste Nom, Promo, Mdp, pas besoin de if, le required html le fait pour nous
            if($_POST != null)
            {
                $bdd = getLocalDb();
                //trouver l'id du nouveau compte
                $query= $bdd->prepare('select max(IdAlumni) from Alumni');
                $query->execute();
                $new_id = $query->fetch();
                $new_id = $new_id['max(IdAlumni)'];
                $new_id += 1;
                //trouver l'id de la commune, pas accessible à l'élève qui s'inscrit
                //fait changer le format. Demander le code postal par exemple
                //$query= $bdd->prepare('select IdCommune from Commune where 'CodePostal = escape($_POST['AdressePostale'])');
                //$idcommune=$query->fetch();
                
                //FIXME le 42 à la place d'idcommune dans la requete
              
                $stmt = $bdd->prepare('insert into Alumni (IdAlumni, NomEleve, PrenomEleve, Promo, AdressePostale, Mail, Mdp, Genre, Tel, Valide, IdCommune, IdGestionnaire) values (:IdAlumni, :NomEleve, :PrenomEleve, :Promo, :AdressePostale, :Mail, :Mdp, :Genre, :Tel, 0, 1, 1)');
                $stmt->bindValue(':IdAlumni', $new_id);
                $stmt->bindValue(':NomEleve', escape($_POST['Nom']));
                $stmt->bindValue(':PrenomEleve', escape($_POST['Prenom']));
                $stmt->bindValue(':Promo', escape($_POST['Promo']));
                $stmt->bindValue(':AdressePostale', escape($_POST['Adresse']));
                $stmt->bindValue(':Mail', escape($_POST['Mail']));
                $stmt->bindValue(':Mdp', escape($_POST['motdepasse']));
                $stmt->bindValue(':Genre', escape($_POST['genre']));
                $stmt->bindValue(':Tel', escape($_POST['Tel']));
                $stmt->execute();
                $stmt->fetch();
                
            }
            redirect('index.php');
            
        ?>