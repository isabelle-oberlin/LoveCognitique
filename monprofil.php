<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            session_start();
            //FIXME est ce que l'admin a le droit de modifier le profil d'un élève ?
            //cas admin
            if (!isAdminConnected() && isUserConnected())
            {
                $mailAlumni = $_SESSION['mail']; 
                $requete = getLocalDb()->prepare('select * from Alumni where mail =:mailA');
                $requete->bindValue(':mailA', "{$mailAlumni}");
                $requete->execute();
                $eleve = $requete->fetch();
                
                $com = getLocalDb()->prepare('select * from commune where IdCommune=?');
                $com->execute(array($eleve['IdCommune']));
                $commune = $com->fetch();

                $exp = getLocalDb()->prepare('select *, DATE_FORMAT(DateDeb, "%d/%m/%Y") as DateDebFr, DATE_FORMAT(DateFin, "%d/%m/%Y") as DateFinFr 
                from experiences, organisations where IdAlumni=? and organisations.IdOrga = experiences.IdOrga order by DateFin desc');
                $exp->execute(array($eleve['IdAlumni']));
                $experiences = $exp->fetchAll();
            }
          
        ?>
    <body>
        <?php
            include_once 'includes/header.php';
        ?>
        
            <?php if (!isAdminConnected() && isUserConnected())
            {?>
        <br>
            <div class=" content">
            <div class="Jumbotron container">
                <h3 class="display-4"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve'] ?></h3>
                <hr class="my-4">
                
                Promotion : <?= $eleve['Promo'] ?><br>
                Commune : <?= $commune['NomCommune'], ", ", $commune['Pays'] ?><br>
                Mail : <?= $eleve['Mail'] ?><br>
                Téléphone : +33<?= $eleve['Tel'] ?><br>
                Genre : <?= $eleve['Genre'] ?>
                        
                <hr class="my-2">
                <p>Vous pouvez laisser votre numéro de téléphone ou votre mail en public, pour que les nouvelles générations vous demandent des conseils ;) Faites-leur profiter de votre expérience !</p>
                <hr class="my-2">
                
                <div>
                    <h2> <span class="display-4">Expériences   </span> <a type="button" class="align-self-center" data-toggle="collapse" data-target="#add" title='Ajouter une expérience'><i class="fas fa-plus-circle"></i></a></h2> 
                
                </div>
                <div id="add" class="collapse in">
                    <div class="form-container">
                            <form class="form-horizontal" method ="POST" action ="traitementProfil.php">

                                <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>
                                           
                                <input type="hidden" name="action" value="ajouter">
                                
                                <div class="h5" >
                                    <label for="type">Type d'expérience : </label>
                                    <input type="radio" name="type" value="Stage" checked required> Stage
                                    <input type="radio" name="type" value="Emploi"> Emploi   
                                    <input type="radio" name="type" value="Volontariat"> Volontariat 
                                    <input type="radio" name="type" value="Césure"> Césure  
                                    <input type="radio" name="type" value="Autre"> Autre  
                                </div>

                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="NomEntre" type="text" placeholder="Nom de l'entreprise" required> 
                                </div>
                                
                                <div class="form-group"> 
                                    <i class="fas input-icon-textarea"></i>
                                    <textarea class="form-control" rows="8" placeholder="Description" name="desc"></textarea> 
                                </div>
                                
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="salaire" type="number" placeholder="Salaire : Laisser vide si non rémunéré" min="0">
                                </div>                                 
                                
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="datedeb" type="date" required>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="datefin" type="date">
                                </div>                           
                                                                
                                <button type="submit" class="btn signin">Allons-y !</button>
                                
                            </form>
                    </div>
                </div>
                <hr class="my-3">
                <?php foreach($experiences as $experience){ ?>
                    <div class="exp">
                        <span class="bold">
                        <?= $experience['TypeExp']," -" ?>
                        <?= $experience['NomOrga'],"-" ?></span>
                        <a type="button" class="align-self-center" data-toggle="collapse" data-target="#<?= "suppr",$experience['IdExp'] ?>" title='Supprimer'> <i class="far fa-trash-alt"></i> </a>
                        <a type="button" class="align-self-center" data-toggle="collapse" data-target="#<?= "edit",$experience['IdExp'] ?>" title='Modifier'> <i class="far fa-edit"></i> </a>
                        <br>
                        <?php if(isset($experience['DateFinFr'])){ 
                            echo "Du ",$experience['DateDebFr']," au ",$experience['DateFinFr'];
                        }
                        else {
                            echo "Depuis le ",$experience['DateDebFr'];
                        }
                        ?> 
                        <br><br>
                        <?= $experience['Description'] ?>
                        <br>
                        <div id="<?= "suppr",$experience['IdExp'] ?>" class="collapse in align-bottom">
                            <form>
                                <input type="hidden" name="id" value="<?= $experience['IdExp'] ?>"><br>
                                <button type="submit" class="btn btn-danger">Suppirmer définitivement</button>
                                <br><br>
                            </form>
                        </div>
                    </div>
                    <div id="<?= "edit",$experience['IdExp'] ?>" class="collapse in">
                        <br>
                         <div class="form-container">
                            <form class="form-horizontal" method ="POST" action ="traitementProfil.php">

                                <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>
                                           
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= $experience['IdExp'] ?>">
                                <div class="h5" >
                                    <label for="type">Type d'expérience : </label>
                                    <input type="radio" name="type" value="Stage" <?php if ($experience['TypeExp']=="Stage") { echo 'checked'; } ?> required> Stage
                                    <input type="radio" name="type" value="Emploi" <?php if ($experience['TypeExp']=="Emploi") { echo 'checked'; } ?> > Emploi   
                                    <input type="radio" name="type" value="Volontariat" <?php if ($experience['TypeExp']=="Volontariat") { echo 'checked'; } ?> > Volontariat 
                                    <input type="radio" name="type" value="Césure" <?php if ($experience['TypeExp']=="Césure") { echo 'checked'; } ?> > Césure  
                                    <input type="radio" name="type" value="Autre" <?php if ($experience['TypeExp']=="Autre") { echo 'checked'; } ?> > Autre  
                                </div>

                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="NomEntre" type="text" placeholder="Nom de l'entreprise" value="<?= $experience['NomOrga'] ?>" required> 
                                </div>
                                
                                <div class="form-group"> 
                                    <i class="fas input-icon-textarea"></i>
                                    <textarea class="form-control" rows="8" placeholder="Description" name="desc" value="" ><?= $experience['Description'] ?></textarea> 
                                </div>
                                
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="salaire" type="number" placeholder="Salaire : Laisser vide si non rémunéré" value="<?= $experience['Salaire'] ?>" min="0">
                                </div>                                 
                                
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="datedeb" type="date" value="<?= $experience['DateDeb'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="datefin" type="date" value="<?= $experience['DateFin'] ?>">
                                </div>                           
                                                                
                                <button type="submit" class="btn signin">Modifier</button>
                                
                            </form>
                        </div>
                    </div>
                    
                    <hr class="my-4">              
                <?php } ?>
                </div> 
                </div>
                
            

                <?php } else {?>
                <br>
                <div class=" content">
                    <div class="Jumbotron container">
                    <h3 class="display-4">Vous n'avez pas de profil particulier sur le site :)</h3>
                    </div>
                    </div>
                <?php } ?>
        
        <?php
            include_once 'includes/footer.php';
            require_once 'includes/scripts.php';
        ?>
    </body>
</html>