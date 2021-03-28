<?php  
    include_once 'includes/functions.php';

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

                $NumOrga = getSetOrganisation(escape($_POST['NomOrga']), escape($_POST['TypeOrga']), escape($_POST['Ville']), escape($_POST['Region']), escape($_POST['Pays']));
                

                $requete = $bdd->prepare('insert into experiences (IdExp, Description, Salaire, DateDeb, DateFin, TypeExp, IdPoste, IdOrga, IdAlumni)
                values (?, ?, ?, ?, ?, ?, ?, ?, ?)');
                
                $requete->execute(array($new_id, escape($_POST['desc']), escape($_POST['salaire']), $_POST['datedeb'], $_POST['datefin'], $_POST['type'], $_POST['poste'], $NumOrga, $_POST['IdAlumni']));
                
                $categorisation = $bdd->prepare('replace into categorise values (?,?); insert into appartient values (?,?)');
                if(isset($_POST['secteur1'])){ $categorisation->execute(array($new_id, $_POST['secteur1'], $NumOrga, $_POST['secteur1'])); $categorisation->closeCursor(); }
                if(isset($_POST['secteur2'])){ $categorisation->execute(array($new_id, $_POST['secteur2'], $NumOrga, $_POST['secteur2'])); }
                break;
                
            //SUPPRIMER EXPERIENCE
            case "suppr":
                $query= $bdd->prepare('delete from experiences where experiences.IdExp=:idexp; delete from categorise where categorise.IdExp=:idexp');
                //parametre id passe en hidden
                $query->bindValue(':idexp', escape($_POST['id']));
                $query->execute();
                break;
            
            //EDITER EXPERIENCE
            case "update":

                $NumOrga = getSetOrganisation(escape($_POST['NomOrga']), escape($_POST['TypeOrga']), escape($_POST['Ville']), escape($_POST['Region']), escape($_POST['Pays']));
                $IdExp = $_POST['id'];

                $requete = $bdd->prepare('update experiences set Description=?, Salaire=?, DateDeb=?, DateFin=?, TypeExp=?, IdPoste=?, IdOrga=? where IdExp=?');
                
                $requete->execute(array(escape($_POST['desc']), escape($_POST['salaire']), $_POST['datedeb'], $_POST['datefin'], $_POST['type'], $_POST['poste'], $NumOrga, $IdExp));
                
                $categorisation = $bdd->prepare('replace into categorise values (?,?); insert into appartient values (?,?)');
                if(isset($_POST['secteur1'])){ $categorisation->execute(array($IdExp, $_POST['secteur1'], $NumOrga, $_POST['secteur1'])); $categorisation->closeCursor(); }
                if(isset($_POST['secteur2'])){ $categorisation->execute(array($IdExp, $_POST['secteur2'], $NumOrga, $_POST['secteur2'])); }
                break;

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
                $stmt->bindValue(':IdCommune', $idcommune);
                $stmt->bindValue(':IdAlumni', $id);
                $stmt->execute();
                
                if($_POST['confiadresse'] != 0){$confiAdresse = 1;} else{$confiAdresse = 0;}
                if($_POST['confimail'] != 0){$confiMail = 1;} else{$confiMail = 0;}
                if($_POST['confitel'] != 0){$confiTel = 1;} else{$confiTel = 0;}
                if($_POST['configenre'] != 0){$confiGenre = 1;} else{$confiGenre = 0;}

                $confidentialite = $bdd->prepare('UPDATE confidentialite SET ConfiAdresse=:ConfiAdresse, ConfiMail=:ConfiMail, ConfiGenre=:ConfiGenre, ConfiTel=:ConfiTel where IdAlumni=:IdAlumni');
                $confidentialite->bindValue(':ConfiAdresse', $confiAdresse);
                $confidentialite->bindValue(':ConfiMail', $confiMail);
                $confidentialite->bindValue(':ConfiGenre', $confiGenre);
                $confidentialite->bindValue(':ConfiTel', $confiTel);
                $confidentialite->bindValue(':IdAlumni', $id);
                $confidentialite->execute();
                break;

        }
        redirect('monprofil.php');
    }
?>