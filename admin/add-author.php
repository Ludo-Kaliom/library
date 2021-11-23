<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logu�
if(strlen($_SESSION['alogin'])==0){
      // On le redirige vers la page de login
      header('location:../index.php');
      // Sinon on peut continuer. Apr�s soumission du formulaire de creation
  } else {
      if (isset($_POST["author"])){
      // On recupere le nom et le statut de la categorie
      $nameauthor= $_POST["nameauthor"];
      date_default_timezone_set('Europe/Paris');
      $DateAndTime = date('Y-m-d H:i:s', time());
      // On prepare la requete d'insertion dans la table tblauthors
      $sql = "INSERT INTO tblauthors (AuthorName, UpdationDate) VALUES (:nameauthor, :DateAndTime)";
      $query = $dbh->prepare($sql);
      $query->bindParam(':nameauthor', $nameauthor, PDO::PARAM_STR);
      $query->bindParam(':DateAndTime', $DateAndTime, PDO::PARAM_STR);
      // On execute la requete
      $query->execute();
      // On stocke dans $_SESSION le message correspondant au resultat de loperation
      $lastInsertId = $dbh->lastInsertId();
              
      if($lastInsertId) {
          $_SESSION['msg']="auteur créé avec succés";
          header('location:manage-authors.php');
      } else {
          $_SESSION['error']="Une erreur s'est produite";
      }
  }
  }

  

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de categories</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
      <?php include('includes/header.php');?>


      <div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Ajouter un auteur</h4>
            </div>
		</div>
		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
                <form role="form" method="post" action="add-author.php">
							
							<div class="form-group">
							<label>Nom de l'auteur</label>
							<input class="form-control" type="text" name="nameauthor" id="nameauthor" required autocomplete="on"  />
							</div>
							
							<button type="submit" name="author" class="btn btn-info">Ajouter</button>
						</form>
                </div>
             </div>
        </div>
    </div>
</div>


      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
