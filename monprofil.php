<html>
        <?php
            include_once 'includes/head.php';
            include_once 'includes/functions.php';
            session_start();
            
            if (!isAdminConnected() && isUserConnected())
            {
                $mailAlumni = $_SESSION['mail']; 
                $requete = getLocalDb()->prepare('select * from Alumni where mail =:mailA');
                $requete->bindValue(':mailA', "{$mailAlumni}");
                $requete->execute();
                $eleve = $requete->fetch();

                $confidentialite = getLocalDb()->prepare('select * from Confidentialite where IdAlumni=?');
                $confidentialite->execute(array($eleve['IdAlumni']));
                $confi = $confidentialite->fetch();

                $com = getLocalDb()->prepare('select * from commune where IdCommune=?');
                $com->execute(array($eleve['IdCommune']));
                $commune = $com->fetch();

                $exp = getLocalDb()->prepare('select *, DATE_FORMAT(DateDeb, "%d/%m/%Y") as DateDebFr, DATE_FORMAT(DateFin, "%d/%m/%Y") as DateFinFr 
                from experiences, organisations where IdAlumni=? and organisations.IdOrga = experiences.IdOrga order by DateFin desc');
                $exp->execute(array($eleve['IdAlumni']));
                $experiences = $exp->fetchAll();

                function selectSecteur(){
                    $query = getLocalDb()->query('select * from Secteur');
                    $secteurs = $query->fetchAll();
                    
                    foreach($secteurs as $secteur){
                        $IdSecteur = $secteur['IdSecteur'];
                        $NomSecteur = $secteur['NomSecteur'];
                        print "<option value=\"$IdSecteur\">$NomSecteur</option>";
                    }
                }
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
                <h3 class="display-4"><?= $eleve['PrenomEleve']," ",$eleve['NomEleve'] ?>  - Promotion : <?= $eleve['Promo'] ?><br></h3>
                <hr class="my-4">
                
                
                <b>Commune : <?= $commune['NomCommune'], ", ", $commune['Pays'] ?></b><br>
                <b>Mail : <?= $eleve['Mail'] ?><br></b>
                <b>Téléphone : +33<?= $eleve['Tel'] ?></b><br>
                <b>Genre : <?= $eleve['Genre'] ?></b>

                 
                <hr class="my-2">
                <p>Vous pouvez laisser votre numéro de téléphone ou votre mail en public, pour que les nouvelles générations vous demandent des conseils ;) Faites-leur profiter de votre expérience !</p>
              
              
              <!-- MODIFICATION PROFIL PAR USER -->    

              <a type="button" class="align-self-center" data-toggle="collapse" data-target="#<?= "modifierprofil",$eleve['IdAlumni'] ?>" title='modifierprofil'> <span class="btn btn-secondary active">Modifier mon profil</span></a>
                <div id="<?= "modifierprofil", $eleve['IdAlumni'] ?>"class="collapse in">
                    <div class="form-container">
                        <form class="form-horizontal" method ="POST" action ="traitementProfil.php">
                            <?php if (isset($error)) { ?>
                            <div class="alert alert-danger">
                                 <strong>Erreur !</strong> <?= $error ?>
                            </div>
                            <?php } ?>

                    
                        <input type="hidden" name="action" value="updateProfile">
                        <input type="hidden" name="id" value="<?= $eleve['IdAlumni'] ?>">
                     
                        <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>

                                
                                <div class="form-group" >
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Nom" type="text" placeholder="Nom" value="<?= $eleve['NomEleve'] ?>" required> 
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Prenom" type="text" placeholder="Prenom" value="<?= $eleve['PrenomEleve'] ?>" required> 
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Promo" type="text" placeholder="Année de sortie" value="<?= $eleve['Promo'] ?>" required>
                                </div>
                                    
                        <div class="select">
                            <select name="slct" id="slct" placeholder="Pays">
                              <option selected disabled>Pays</option>
                              <option value="1">Pure CSS</option>
                              <option value="2">No JS</option>
                              <option value="3">Nice!</option>
                            </select>
                        </div>
                        <div id="Ajoutertruc" class="collapse in">
                            C4ESTBON
                        </div>
                              
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="confiadresse" name="confiadresse" <?php if ($confi['ConfiAdresse']!=0) { echo 'checked'; } ?> >
                                    <label class="custom-control-label" for="confiadresse">Rendre ces informations visibles à tous les éléves</label>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="Ville" type="text" placeholder="Ville" value="<?= $commune['NomCommune'] ?>">
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="Region" type="text" placeholder="Region" value="<?= $commune['Region'] ?>">
                                </div> 
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                <input class="form-control" name="Pays" type="text" placeholder="Pays" value="<?= $commune['Pays'] ?>">
                                </div>
                               
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="confimail" name="confimail" <?php if ($confi['ConfiMail']!=0) { echo 'checked'; } ?> >
                                    <label class="custom-control-label" for="confimail">Rendre cette information visible à tous les éléves</label>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Mail" type="mail" placeholder="Mail" value="<?= $eleve['Mail'] ?>"  required>
                                </div>

                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="motdepasse" type="password" placeholder="Mot de passe" value="<?= $eleve['Mdp'] ?>"required>
                                </div>
 
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="confitel" name="confitel" <?php if ($confi['ConfiTel']!=0) { echo 'checked'; } ?> >
                                    <label class="custom-control-label" for="confitel">Rendre cette information visible à tous les éléves</label>
                                </div>
                                <div class="form-group">
                                    <i class="fas input-icon"></i>
                                    <input class="form-control" name="Tel" type="text" value="<?= $eleve['Tel'] ?>" placeholder="Tel">
                                </div>

                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="configenre" name="configenre" <?php if ($confi['ConfiGenre']!=0) { echo 'checked'; } ?> >
                                    <label class="custom-control-label" for="configenre">Rendre cette information visible à tous les éléves</label>
                                </div>
                                <div class="" >
                                    
                                    <input type="radio" name="genre" value="H" <?php if ($eleve['Genre']=="H") { echo 'checked'; } ?> required> Homme 
                                    <input type="radio" name="genre" value="F"<?php if ($eleve['Genre']=="F") { echo 'checked'; } ?> > Femme 
                                    <input type="radio" name="genre" value="NB" <?php if ($eleve['Genre']=="NB") { echo 'checked'; } ?> > NB   
                                </div>

                                <button type="submit" class="btn signin">Allons-y !</button>
                            
                            </form>
                    
                    </div>

                </div>

               
              
                <!-- EXPERIENCES -->
                
                <div>
                   <h2> <span class="display-4">Expériences</span> <a type="button" class="align-self-center" data-toggle="collapse" data-target="#add" title='Ajouter une expérience'><i class="fas fa-plus-circle"></i></a></h2> 
                </div>
              
                            <!-- AJOUT EXP -->
                    <div id="add" class="form-container collapse in">
                            <form class="form-horizontal" method ="POST" action ="traitementProfil.php">

                                <?php if (isset($error)) { ?>
                                    <div class="alert alert-danger">
                                        <strong>Erreur !</strong> <?= $error ?>
                                    </div>
                                <?php } ?>
                                           
                                <input type="hidden" name="action" value="ajouter">
                                <input type="hidden" name="IdAlumni" value="<?= $eleve['IdAlumni'] ?>">
                                
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
                                
                                
                                    <label for="datedeb"> Date de début </label>
                                    <div class="form-group">
                                        <i class="fas input-icon"></i>
                                        <input class="form-control" name="datedeb" placeholder="Pipou" type="date" required>
                                    </div>
                                
                                    <label for="datedeb"> Date de fin </label>
                                    <div class="form-group">
                                        <i class="fas input-icon"></i>
                                    <input class="form-control" name="datefin" type="date">
                                    </div> 
                                
                                                                
                                <button type="submit" class="btn signin">Allons-y !</button>
                                
                            </form>
                    </div>
                
                <hr class="my-3">
                <!-- AFFICHAGE -->
                <?php foreach($experiences as $experience){ ?>
                    <div class="exp">
                        <span class="bold">
                        <?= $experience['TypeExp']," -" ?>
                        <?= $experience['NomOrga']," -" ?></span>
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

                    <!-- SUPPRESSION -->
                        <div id="<?= "suppr",$experience['IdExp'] ?>" class="collapse in align-bottom">
                            <form method ="POST" action ="traitementProfil.php">
                                <input type="hidden" name="action" value="suppr">
                                <input type="hidden" name="id" value="<?= $experience['IdExp'] ?>"><br>
                                <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                                <br><br>
                            </form>
                        </div>
                    </div>

                    <!-- EDITION -->
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