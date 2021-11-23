<?php
// On d�marre ou on r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');


// Si l'utilisateur n'est logu� ($_SESSION['alogin'] est vide)
if(strlen($_SESSION['alogin'])==0) {
    // Si l'utilisateur n'est logu� ($_SESSION['alogin'] est vide)
    // On le redirige vers la page d'accueil
    // Sinon on affiche la liste des lecteurs de la table tblreaders
	header('location:../index.php');
} else { 
    // On r�cup�re tous les lecteurs dans la base de donn�es
    $sql="SELECT * FROM tblreaders ORDER BY id ASC";
    $query=$dbh->prepare($sql);
    $query->execute();
    $resultats= $query->fetchAll(PDO::FETCH_OBJ);

    if (isset($_GET['inid'])){
         // Lors d'un click sur un bouton "inactif", on r�cup�re la valeur de l'identifiant
    // du lecteur dans le tableau $_GET['inid']
        $inid=$_GET['inid'];
        $status=0;
    //on met à jour le statut (0) dans la table tblreaders pour cet identifiant de lecteur
        $sql="UPDATE tblreaders SET Status=:status WHERE id=:inid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':inid', $inid, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->execute();
    }

    if (isset($_GET['id'])){
        // Lors d'un click sur un bouton "actif", on r�cup�re la valeur de l'identifiant
        // du lecteur dans le tableau $_GET['id']
        $id=$_GET['id'];
   //on met à jour le statut (0) dans la table tblreaders pour cet identifiant de lecteur
        $status=1;
        $sql="UPDATE tblreaders SET Status=:status WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->execute();
   }

   if (isset($_GET['del'])){
    // Lors d'un click sur un bouton "supprimer", on r�cup�re la valeur de l'identifiant
    // du lecteur dans le tableau $_GET['del']
    $del=$_GET['del'];
    // et on met � jour le statut (2) dans la table tblreaders pour cet identifiant de lecteur
    $status=2;
    $sql="UPDATE tblreaders SET Status=:status WHERE id=:del";
    $query = $dbh->prepare($sql);
    $query->bindParam(':del', $del, PDO::PARAM_INT);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->execute();
    }
}




?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Reg lecteurs</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
     <!--On inclue ici le menu de navigation includes/header.php-->
<?php include('includes/header.php');?>
<div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Gestion du registre des lecteurs</h4>
            </div>
		</div>

        <div class="row">
			<?php if(!empty($_SESSION['error'])) {?>
				<div class="col-md-6">
					<div class="alert alert-danger" >
						<strong>Erreur :</strong> 
						<?php echo $_SESSION['error'];?>
						<?php $_SESSION['error']="";?>
					</div>
				</div>
			<?php } ?>
			<?php if(!empty($_SESSION['msg'])) {?>
				<div class="col-md-6">
					<div class="alert alert-success" >
							<strong>Succes :</strong> 
						<?php echo $_SESSION['msg'];?>
						<?php $_SESSION['msg']="";?>
					</div>
				</div>
			<?php } ?>
			<?php if(!empty($_SESSION['updatemsg'])) {?>
				<div class="col-md-6">
					<div class="alert alert-success" >
						<strong>Succes :</strong> 
						<?php echo $_SESSION['updatemsg'];?>
						<?php $_SESSION['updatemsg']="";?>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($_SESSION['delmsg'])) {?>
				<div class="col-md-6">
					<div class="alert alert-success" >
						<strong>Succes :</strong> 
						<?php echo $_SESSION['delmsg'];?>
						<?php $_SESSION['delmsg']="";?>
					</div>
				</div>
			<?php } ?>
		</div>


		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
                <div class="row">
                <div class="col">
                <table class="table table-striped table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID Lecteur</th>
                            <th scope="col">Nom du lecteur</th>
                            <th scope="col">Email</th>
                            <th scope="col">Portable</th>
                            <th scope="col">Date d'inscription</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>      
                        <tbody>
                            <?php 
                                if (is_array($resultats)){
                                    $cnt= 1;
                                    foreach ($resultats AS $result){
                                    ?>
                                    <tr>
                                    <td><?php echo $cnt ?> </td>
                                    <td><?php echo $result->ReaderId; ?></td>
                                    <td><?php echo $result->FullName; ?></td>
                                    <td><?php echo $result->EmailId; ?></td>
                                    <td><?php echo $result->MobileNumber; ?></td>
                                    <td><?php echo $result->RegDate; ?></td>
                                    <td><?php if ($result->Status == 1){
                                        echo "Actif";
                                    } elseif ($result->Status == 0) { 
                                        echo "Bloqué";
                                    } elseif ($result->Status == 2) { 
                                        echo "Supprimé";
                                    }
                                    ?></td>
                                    <td>

                                    <?php if ($result->Status == 2){
                                        
                                    } elseif ($result->Status == 0) { ?>
                                    <a href="reg-readers.php?id=<?php echo $result->id ?>">
                                    <button class="btn btn-primary">Actif</button></a>

                                    <a href="reg-readers?del=<?php echo $result->id ?>">
                                    <button type="button" class="btn btn-danger">Supprimer</button></a>
                                    <?php
                                    } elseif ($result->Status == 1) { ?>

                                    <a href="reg-readers.php?inid=<?php echo $result->id ?>">
                                    <button class="btn btn-dark">Inactif</button></a>

                                    <a href="reg-readers?del=<?php echo $result->id ?>">
                                    <button type="button" class="btn btn-danger">Supprimer</button></a>
                                    <?php } ?>

                                    </td>
                                    <?php
                                    $cnt++; 
                                    }
                                }
                            ?>    
                        </tbody>
                        </table>
            </div>
        </div>
                </div>
             </div>
        </div>
    </div>
</div>
 

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
</body>
</html>
