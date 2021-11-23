<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logu�
if(strlen($_SESSION['alogin'])==0){
    // On le redirige vers la page de login
    header('location:../index.php');
    // Sinon on peut continuer. Apr�s soumission du formulaire de creation
} else {
    if (isset($_POST["category"])){
    // On recupere le nom et le statut de la categorie
    $namecategory= $_POST["namecategory"];
    date_default_timezone_set('Europe/Paris');
    $DateAndTime = date('Y-m-d H:i:s', time());
    $statuscategory = $_POST["statuscategory"];
    if ($statuscategory == 0){
        $status = 0;
    } else if ($statuscategory == 1){
        $status = 1;
    }
    $resultatstatus = $status;
    // On prepare la requete d'insertion dans la table tblcategory
    $sql = "INSERT INTO `tblcategory`(`CategoryName`, `Status`, UpdationDate) VALUES (:namecategory, :res, :DateAndTime)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':namecategory', $namecategory, PDO::PARAM_STR);
    $query->bindParam(':res', $resultatstatus, PDO::PARAM_STR);
    $query->bindParam(':DateAndTime', $DateAndTime, PDO::PARAM_STR);
    // On execute la requete
    $query->execute();
    // On stocke dans $_SESSION le message correspondant au resultat de loperation
    $lastInsertId = $dbh->lastInsertId();
		
    if($lastInsertId) {
        $_SESSION['msg']="categorie cree avec succes";
        header('location:manage-categories.php');
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
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<!-- On affiche le titre de la page-->
	<!-- On affiche le formulaire de creation-->
	<!-- Par defaut, la categorie est active-->

    <div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Ajouter une catégorie</h4>
            </div>
		</div>
		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
                <form role="form" method="post" action="add-category.php">
                        <div class="form-group">
                        <label>Nom de la catégorie</label>
                        <input class="form-control" type="text" name="namecategory" id="name-category" required autocomplete="on"  />
                        </div>
                        <label>Statut</label>
                        <div class="form-group">
                        <input type="radio" name="statuscategory" value="1" checked> Active<br>
                        </div>

                        <div class="form-group">
                        <input type="radio" name="statuscategory" value="0"> Inactive<br>
                        </div>
                        
                        <button type="submit" name="category" class="btn btn-info">Créer</button>
                    </form>         
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
