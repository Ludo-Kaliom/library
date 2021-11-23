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
        $catid = intval($_GET['catid']);
        $category = $_POST['category'];
        $statut = $_POST['status'];
		// On prepare la requete de mise a jour
        $sql2 = "UPDATE tblcategory SET CategoryName=:category, Status=:status WHERE id=:catid";
        // On prepare la requete de recherche des elements de la categorie dans tblcategory
        $query2 = $dbh->prepare($sql2);
        $query2->bindParam(':category', $category, PDO::PARAM_STR);
        $query2->bindParam(':status', $statut, PDO::PARAM_INT);
        $query2->bindParam(':catid', $catid, PDO::PARAM_INT);
		// On execute la requete
        $query2->execute();
		// On stocke dans $_SESSION le message "Categorie mise a jour"
		$_SESSION['updatemsg'] = "Catégorie mise à jour";
		
		// On redirige l'utilisateur vers manage-categories.php
        header('location:manage-categories');
    }
}
// error_log(print_r($result, 1));
//         error_log($_sql);

$catid = intval($_GET['catid']);
$sql = "SELECT * FROM tblcategory WHERE id=:catid";
$query = $dbh->prepare($sql);
$query->bindParam(':catid', $catid, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Categories</title>
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
<!-- On affiche le titre de la page "Editer la categorie-->
<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 offset-md-3" >
			<div class="row pad-botm">
			<div class="col-md-12">
				<h4 class="header-line">Editer la catégorie</h4>
			</div>
		</div>

				<div class="panel panel-info">
					<div class="panel-body">
					<?php
                    if (!empty($result)) {
                ?>
                <form method="post">
                    <div>
                        <label>Nom</label>
                        <input type="text" name="category" value="<?php echo $result->CategoryName ;?>">
                    </div>

                     <div>
                        <label>Statut</label>
                        <?php if ($result->Status == 1) { ?>
                            <div>
                                <input type="radio" name="status" value="1" checked> Active
                            </div>
                            <div>
                                <input type="radio" name="status" value="0" > Inactive
                            </div>
                        <?php } else { ?>
                            <div>
                                <input type="radio" name="status" value="1"> Active 
                            </div>
                            <div>
                                <input type="radio" name="status" value="0" checked> Inactive
                            </div>

                        <?php } ?>
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
