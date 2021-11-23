<?php
// On d�marre ou on r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0){
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
  header('location:../index.php');
} else {
// sinon on r�cup�re les informations � afficher
  // On récupère le nombre de livres
  $sql = "SELECT id FROM tblbooks";
  $query = $dbh->prepare($sql);
  $query->execute();
  $result = $query->fetchAll(PDO::FETCH_OBJ);
  $books = count($result);

  // $sql = "SELECT COUNT(id) FROM tblbooks";
  // $query = $dbh->prepare($sql);
  // $query->execute();
  // $books = $query->fetch(PDO::FETCH_COLUMN);

	// On r�cup�re le nombre de livres en pr�t depuis la table tblissuedbookdetails
  $sql1 = "SELECT id FROM tblissuedbookdetails";
  $query1 = $dbh->prepare($sql1);
  $query1->execute();
  $result1 = $query1->fetchAll(PDO::FETCH_OBJ);
  $issuedbooks = count($result1);
	
	// On r�cup�re le nombre de livres retourn�s  depuis la table tblissuedbookdetails
	// Ce sont les livres dont le statut est 1
  $rsts = 1;
  $sql2 = "SELECT id FROM tblissuedbookdetails WHERE ReturnStatus=:rsts";
  $query2 = $dbh->prepare($sql2);
  $query2->bindParam(':rsts', $rsts, PDO::PARAM_STR);
  $query2->execute();
  $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
  $returnbooks = count($result2);
	
	// On r�cup�re le nombre de lecteurs dans la table tblreaders
  $sql3 = "SELECT id FROM tblreaders";
  $query3 = $dbh->prepare($sql3);
  $query3->execute();
  $result3 = $query3->fetchAll(PDO::FETCH_OBJ);
  $readers = count($result3);
	
	// On r�cup�re le nombre d'auteurs dans la table tblauthors
  $sql4 = "SELECT id FROM tblauthors";
  $query4 = $dbh->prepare($sql4);
  $query4->execute();
  $result4 = $query4->fetchAll(PDO::FETCH_OBJ);
  $authors = count($result4);
	
	// On r�cup�re le nombre de cat�gories dans la table tblcategory
  $sql5 = "SELECT id FROM tblcategory";
  $query5 = $dbh->prepare($sql5);
  $query5->execute();
  $result5 = $query5->fetchAll(PDO::FETCH_OBJ);
  $category = count($result5);


?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Tab bord administration</title>
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
<!-- On affiche le titre de la page : TABLEAU DE BORD ADMINISTRATION-->
<div class="content-wrapper">
          <div class="container">
               <div class="row pad-botm">
                    <div class="col-md-12">
                    <h4 class="header-line">Administration - Tableau de bord</h4>
                    </div>
               </div>
          </div>

		<div class="row">
          <!-- On affiche la carte Nombre de livres -->
          <div class="col-md-3">
               <div class="alert alert-light text-center border-info role=alert">
                  <span class="fa fa-book" style="font-size:100px;color:green"></span><br>
                  <span><?php echo $books ?></span><br>
                  Nombre de livres
               </div>
          </div>
          <!-- On affiche la carte Livres en pr�t -->
          <div class="col-md-3">
               <div class="alert alert-light text-center border-info role=alert">
                  <span class="fa fa-bars" style="font-size:100px;color:grey"></span><br>
                  <span><?php echo $issuedbooks ?></span><br>
                  livres en prêt
               </div>
          </div>
          <!-- On affiche la carte Livres retourn�s -->
          <div class="col-md-3">
               <div class="alert alert-light text-center border-info role=alert">
                  <span class="fa fa-recycle" style="font-size:100px;color:grey"></span><br>
                  <span><?php echo $returnbooks ?></span><br>
                  Livres retournés
               </div>
          </div>
           <!-- On affiche la carte Lecteurs -->
          <div class="col-md-3">
               <div class="alert alert-light text-center border-info role=alert">
                  <span class="fa fa-users" style="font-size:100px;color:olive"></span><br>
                  <span><?php echo $readers ?></span><br>
                  Lecteurs
               </div>
          </div>
          	<!-- On affiche la carte Auteurs -->
          <div class="col-md-3">
               <div class="alert alert-light text-center border-info role=alert">
                  <span class="fa fa-users" style="font-size:100px;color:blue"></span><br>
                  <span><?php echo $authors ?></span><br>
                  Auteurs
               </div>
          </div>
          <!-- On affiche la carte Cat�gories -->
          <div class="col-md-3">
               <div class="alert alert-light text-center border-info role=alert">
                  <span class="fa fa-file-archive-o" style="font-size:100px;color:black"></span><br>
                  <span><?php echo $category?></span><br>
                  Catégories
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
<?php } ?>
