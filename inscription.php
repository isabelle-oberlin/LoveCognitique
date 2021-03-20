<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            session_start();

            //formulaire et création du compte. L'administrateur changera simplement le bool "validé"; 
            //pour l'instant on peut créer un compte avec juste Nom, Promo, Mdp
            if (!empty($_POST['Nom']) and !empty($_POST['Mot de passe']) and !empty($_POST['Promo']))
            {
                $bdd = getLocalDb();
                //trouver l'id du nouveau compte
                $query= $bdd->prepare('select max(IdAlumni) from Alumni');
                $query->execute();
                $new_id = $query->fetch();
                //trouver l'id de la commune, pas accessible à l'élève qui s'inscrit
                //fait changer le format. Demander le code postal par exemple
                //$query= $bdd->prepare('select IdCommune from Commune where 'CodePostal = escape($_POST['AdressePostale'])');
                //$idcommune=$query->fetch();

                //FIXME le 42 à la place d'idcommune dans la requete
                $stmt = $bdd->prepare('insert into Alumni (IdAlumni, NomEleve, PrenomEleve, Promo, AdressePostale, Mail, Mdp, Genre, Tel, Valide, IdCommune, IdGestionnaire) values (:IdAlumni, :NomEleve, :PrenomEleve, :Promo, :AdressePostale, :Mail, :Mdp, :Genre, :Tel, 0, 42, 0)');
                $stmt->bindParam(':IdAlumni', $new_id);
                $stmt->bindParam(':NomEleve', escape($_POST['IdAlumni']));
                $stmt->bindParam(':PrenomEleve', escape($_POST['PrenomEleve']));
                $stmt->bindParam(':Promo', escape($_POST['Promo']));
                $stmt->bindParam(':AdressePostale', escape($_POST['AdressePostale']));
                $stmt->bindParam(':Mail', escape($_POST['Mail']));
                $stmt->bindParam(':Mdp', escape($_POST['Mdp']));
                $stmt->bindParam(':Genre', escape($_POST['Genre']));
                $stmt->bindParam(':Tel', escape($_POST['Tel']));
                $stmt->execute();
                $stmt->fetch();
                //FIXME no errors caught, a print here does not work. But cannot create accounts
            }
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        <div class="content">
            <br/>
            <div class="Jumbotron container">
                <h1 class="display-4">Inscription</h1>
                
                <hr class="my-4">
                <?php if(isUserConnected() == false){ ?>
                    <div class="form-container">
                            <form class="form-horizontal" method = "POST" action = "inscription.php">

                                <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>

                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Nom" type="text" placeholder="Nom">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Prenom" type="text" placeholder="Prenom">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Promo" type="text" placeholder="Année de sortie">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="Adresse" type="text" placeholder="Adresse">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Mail" type="mail" placeholder="Mail">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Mot de passe" type="password" placeholder="Mot de passe">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Tel" type="text" placeholder="Tel">
                                </div>

                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input type="radio" name="genre" value="Homme"> Homme 
                                    <input type="radio" name="genre" value="Femme"> Femme 
                                    <input type="radio" name="genre" value="NB"> NB   
                                </div>
                                


                                <button class="btn signin">Allons-y !</button>
                                
                                <span class="forgot-pass">Vous recevrez une confirmation de notre administrateur. Patience d'ici là ;)</span>
                            </form>
                        </div>
                <?php } else{ ?>
                Vous êtes déjà inscrit.e ! 
                <?php } ?>

            </div>
        </div>
        <?php
            include_once 'includes/footer.php';
        ?>
    </body>
</html>