<html>


<?php  include_once 'includes/functions.php';
            session_start();

            //formulaire et création du compte. L'administrateur changera simplement le bool "validé"; 
            //pour l'instant on peut créer un compte avec juste Nom, Promo, Mdp, pas besoin de if, le required html le fait pour nous
            if($_POST != null)
            {
                $action = escape($_POST['action']);
                $bdd = getLocalDb();
                switch ($action){

                    //AJOUTER EXPERIENCE
                    case "ajouter" :
                        
                        $query= $bdd->prepare('select max(IdExp) from experiences');
                        $query->execute();
                        $new_id = $query->fetch();
                        $new_id = $new_id['max(IdExp)'];
                        $new_id += 1;
                        
                        $requete = $bdd->prepare('insert into experiences (IdExp, Description, Salaire, DateDeb, DateFin, TypeExp, IdOrga, IdAlumni)
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
                    case "updateProfile" : 

                        $id = escape($_POST['id']);
                        $idcommune= getSetCommune(escape($_POST['Ville']), escape($_POST['Region']), escape($_POST['Pays']));

                        $stmt = $bdd->prepare('UPDATE alumni SET NomEleve=:NomEleve, PrenomEleve=:PrenomEleve, Promo=:Promo, Mail=:Mail, Mdp=:Mdp, Genre=:Genre, Tel=:Tel, Valide=1, IdCommune=:IdCommune where IdAlumni=:IdAlumni');
                        
                        $stmt->bindValue(':NomEleve', escape($_POST['Nom']));
                        $stmt->bindValue(':PrenomEleve', escape($_POST['Prenom']));
                        $stmt->bindValue(':Promo', escape($_POST['Promo']));
                        $stmt->bindValue(':Mail', escape($_POST['Mail']));
                        $stmt->bindValue(':Mdp', escape($_POST['motdepasse']));
                        $stmt->bindValue(':Genre', escape($_POST['genre']));
                        $stmt->bindValue(':Tel', escape($_POST['Tel']));
                        //Pour l'instant on a encore un pb s'il met une nouvelle commune dans le edit de son profil.
                        $stmt->bindValue(':IdCommune', $idcommune);
                        $stmt->bindValue(':IdAlumni', $id);
                        $stmt->execute();
                        
                        if($_POST['confiadresse'] != 0){$confiAdresse = 1;} else{$confiAdresse = 0;}
                        if($_POST['confimail'] != 0){$confiMail = 1;} else{$confiMail = 0;}
                        if($_POST['confitel'] != 0){$confiTel = 1;} else{$confiTel = 0;}
                        if($_POST['configenre'] != 0){$confiGenre = 1;} else{$confiGenre = 0;}

                        $confidentialite = $bdd->prepare('UPDATE Confidentialite SET ConfiAdresse=:ConfiAdresse, ConfiMail=:ConfiMail, ConfiGenre=:ConfiGenre, ConfiTel=:ConfiTel where IdAlumni=:IdAlumni');
                        $confidentialite->bindValue(':ConfiAdresse', $confiAdresse);
                        $confidentialite->bindValue(':ConfiMail', $confiMail);
                        $confidentialite->bindValue(':ConfiGenre', $confiGenre);
                        $confidentialite->bindValue(':ConfiTel', $confiTel);
                        $confidentialite->bindValue(':IdAlumni', $id);
                        $confidentialite->execute();
                        $confidentialite->fetch();
                }
                redirect('monprofil.php');
            }
?>