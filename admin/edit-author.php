<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logué
if(strlen($_SESSION['alogin'])==0) { 
     // On le redirige vers la page de login  
      header('location:../index.php');
 } else { 
 // Sinon
      // Apres soumission du formulaire de categorie
     if (isset($_POST['update'])) {
           // On recupere l'identifiant, le statut, le nom
          $authid = intval($_GET['authid']);
          $authname = $_POST['authname'];
           // On prepare la requete de mise a jour
          $sql2 = "UPDATE tblauthors SET AuthorName=:authname WHERE id=:authid";
         // On prepare la requete de recherche des elements de la categorie dans tblauthname
          $query2 = $dbh->prepare($sql2);
          $query2->bindParam(':authname', $authname, PDO::PARAM_STR);
          $query2->bindParam(':authid', $authid, PDO::PARAM_INT);
           // On execute la requete
          $query2->execute();
           // On stocke dans $_SESSION le message "Categorie mise a jour"
          $_SESSION['updatemsg'] = "Auteur mis à jour";
           
           // On redirige l'utilisateur vers manage-categories.php
          header('location:manage-authors');
     }
 }
 
 $authid = intval($_GET['authid']);
 $sql = "SELECT * FROM tblauthors WHERE id=:authid";
 $query = $dbh->prepare($sql);
 $query->bindParam(':authid', $authid, PDO::PARAM_INT);
 $query->execute();
 $result = $query->fetch(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Auteurs</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
<!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->

<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 offset-md-3" >
			<div class="row pad-botm">
			<div class="col-md-12">
				<h4 class="header-line">Changer le mot de passe</h4>
			</div>
		</div>


				<div class="panel panel-info">
					<div class="panel-body">
					<?php
                    if (!empty($result)) {
                ?>
                <form method="post">
                    <div>
                        <label>Nom de l'auteur</label>
                        <input type="text" name="authname" value="<?php echo $result->AuthorName ;?>">
                    </div>

                    <button type="submit" name="update" class="btn btn-info">Mise à jour</button>
                </form>
                <?php } ?>
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
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
