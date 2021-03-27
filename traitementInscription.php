<?php
    include_once 'includes/functions.php';       
            
    //formulaire et création du compte. L'administrateur changera simplement le bool "validé"; 
    //pour l'instant on peut créer un compte avec juste Nom, Promo, Mdp, pas besoin de if, le required html le fait pour nous
    if($_POST != null)
    {
        $bdd = getLocalDb();
        //trouver l'id du nouveau compte
        $query= $bdd->prepare('select max(IdAlumni) from alumni');
        $query->execute();
        $new_id = $query->fetch();
        $new_id = $new_id['max(IdAlumni)'];
        $new_id += 1;


        $idcommune= getSetCommune(escape($_POST['Ville']), escape($_POST['Region']), escape($_POST['Pays']));

        
        $stmt = $bdd->prepare('insert into alumni (IdAlumni, NomEleve, PrenomEleve, Promo, Mail, Mdp, Genre, Tel, Valide, IdCommune, IdGestionnaire) 
        values (:IdAlumni, :NomEleve, :PrenomEleve, :Promo, :Mail, :Mdp, :Genre, :Tel, 0, :idCommune, 1)');
        $stmt->bindValue(':IdAlumni', $new_id);
        $stmt->bindValue(':NomEleve', escape($_POST['Nom']));
        $stmt->bindValue(':PrenomEleve', escape($_POST['Prenom']));
        $stmt->bindValue(':Promo', escape($_POST['Promo']));
        $stmt->bindValue(':Mail', escape($_POST['Mail']));
        $stmt->bindValue(':Mdp', escape($_POST['motdepasse']));
        $stmt->bindValue(':Genre', escape($_POST['genre']));
        $stmt->bindValue(':Tel', escape($_POST['Tel']));
        $stmt->bindValue(':idCommune', $idcommune);
        $stmt->execute();
        $stmt->fetch();
        
        
        if($_POST['confiadresse']){$confiAdresse = 1;} else{$confiAdresse = 0;}
        if($_POST['confimail']){$confiMail = 1;} else{$confiMail = 0;}
        if($_POST['confitel']){$confiTel = 1;} else{$confiTel = 0;}
        if($_POST['configenre']){$confiGenre = 1;} else{$confiGenre = 0;}
        
        $confidentialite = $bdd->prepare('insert into confidentialite (IdConfidentialite, ConfiAdresse, ConfiMail, ConfiGenre, ConfiTel, IdAlumni) 
        values (:IdConfidentialite, :ConfiAdresse, :ConfiMail, :ConfiGenre, :ConfiTel, :IdAlumni)');
        $confidentialite->bindValue(':IdConfidentialite', $new_id);
        $confidentialite->bindValue(':ConfiAdresse', $confiAdresse);
        $confidentialite->bindValue(':ConfiMail', $confiMail);
        $confidentialite->bindValue(':ConfiGenre', $confiGenre);
        $confidentialite->bindValue(':ConfiTel', $confiTel);
        $confidentialite->bindValue(':IdAlumni', $new_id);
        $confidentialite->execute();
        $confidentialite->fetch();
        
    }
    redirect('index.php');
    
?>