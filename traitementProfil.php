<html>


<?php  include_once 'includes/functions.php';
            session_start();

            //formulaire et création du compte. L'administrateur changera simplement le bool "validé"; 
            //pour l'instant on peut créer un compte avec juste Nom, Promo, Mdp, pas besoin de if, le required html le fait pour nous
            if($_POST != null)
            {
                $action = escape($_POST['action']);
                switch ($action){
                    case "ajouter" :
                        
                        $query= $bdd->prepare('select max(IdExp) from experiences');
                        $query->execute();
                        $new_id = $query->fetch();
                        $new_id = $new_id['max(IdExp)'];
                        $new_id += 1;
                        
                        $requete = getLocalDb()->prepare('insert into experiences (IdExp, Description, Salaire, DateDeb, DateFin, TypeExp, IdOrga, IdAlumni)
                        values (?, ?, ?, ?, ?, ?, ?, ?');
                        $requete->execute(array($new_id, escape($_POST['desc']), escape($_POST['salaire']), $_POST['datedeb']), $_POST['datefin'], $_POST['type'], $NumOrga, $_POST['IdAlumni']);

                        case "modifierprofil" : 
                            $stmt->$bdd->prepare('UPDATE alumni SET IdAlumni=:IdAlumni NomEleve=:NomEleve, PrenomEleve= :PrenomEleve,Promo=:Promo, Ville= :Ville,Mail=:Mail Mdp= :Mdp, Genre= :Genre, Tel= :Tel, Valide= 1, IdCommune= :IdCommune');
                            $stmt->bindValue(':IdAlumni', $new_id);
                            $stmt->bindValue(':NomEleve', escape($_POST['Nom']));
                            $stmt->bindValue(':PrenomEleve', escape($_POST['Prenom']));
                            $stmt->bindValue(':Promo', escape($_POST['Promo']));
                            $stmt->bindValue(':Ville', escape($_POST['Ville']));
                            $stmt->bindValue(':Mail', escape($_POST['Mail']));
                            $stmt->bindValue(':Mdp', escape($_POST['motdepasse']));
                            $stmt->bindValue(':Genre', escape($_POST['genre']));
                            $stmt->bindValue(':Tel', escape($_POST['Tel']));
                            $stmt->bindValue(':idCommune', $idcommune);
                            $stmt->execute();
                            $stmt->fetch();
                        }
            }
?>