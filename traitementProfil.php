<html>


<?php  include_once 'includes/functions.php';
            session_start();

            //formulaire et création du compte. L'administrateur changera simplement le bool "validé"; 
            //pour l'instant on peut créer un compte avec juste Nom, Promo, Mdp, pas besoin de if, le required html le fait pour nous
            if($_POST != null)
            {
                $action = escape($_POST['action']);
                switch ($action){

                    //AJOUTER EXPERIENCE
                    case "ajouter" :
                        
                        $query= $bdd->prepare('select max(IdExp) from experiences');
                        $query->execute();
                        $new_id = $query->fetch();
                        $new_id = $new_id['max(IdExp)'];
                        $new_id += 1;
                        
                        $requete = getLocalDb()->prepare('insert into experiences (IdExp, Description, Salaire, DateDeb, DateFin, TypeExp, IdOrga, IdAlumni)
                        values (?, ?, ?, ?, ?, ?, ?, ?');
                        $requete->execute(array($new_id, escape($_POST['desc']), escape($_POST['salaire']), $_POST['datedeb']), $_POST['datefin'], $_POST['type'], $NumOrga, $_POST['IdAlumni']);



                    //SUPPRIMER EXPERIENCE
                    case "suppr":
                        $query= $bdd->prepare('delete from experiences where experiences.IdExp = :idexp');
                        //C EST LE BON ID COMME CA???
                        // pas besoin de faire une requête à part avec $idexp = $idexp['IdExp'];
                        $query->bindValue(':idexp', escape($_POST['id']));
                        $query->execute();
                        $query->fetch();
              

                    //MODIFIER PROFIL
                    case "modifierprofil" : 

                $mailAlumni = $_SESSION['mail']; 
                $requete = getLocalDb()->prepare('select IdAlumni from Alumni where mail =:mailA');
                $requete->bindValue(':mailA', "{$mailAlumni}");
                $requete->execute();
                $id = $requete->fetch();

                            $stmt->$bdd->prepare('UPDATE alumni SET IdAlumni=:IdAlumni NomEleve=:NomEleve, PrenomEleve= :PrenomEleve,Promo=:Promo, Ville= :Ville, Région = :Région, Pays=:Pays, Mail=:Mail Mdp= :Mdp, Genre= :Genre, Tel= :Tel, Valide= 1, IdCommune= :IdCommune');
                            $stmt->bindValue(':IdAlumni', $id);
                            $stmt->bindValue(':NomEleve', escape($_POST['Nom']));
                            $stmt->bindValue(':PrenomEleve', escape($_POST['Prenom']));
                            $stmt->bindValue(':Promo', escape($_POST['Promo']));
                            $stmt->bindValue(':Ville', escape($_POST['Ville']));
                            $stmt->bindValue(':Région', escape($_POST['Région']));
                            $stmt->bindValue(':Pays', escape($_POST['Pays']));
                            $stmt->bindValue(':Mail', escape($_POST['Mail']));
                            $stmt->bindValue(':Mdp', escape($_POST['motdepasse']));
                            $stmt->bindValue(':Genre', escape($_POST['genre']));
                            $stmt->bindValue(':Tel', escape($_POST['Tel']));
                            //Pour l'instant on a encore un pb s'il met une nouvelle commune dans le edit de son profil.
                            $stmt->bindValue(':idCommune', $idcommune);
                            $stmt->execute();
                        }
            }
?>