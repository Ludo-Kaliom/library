<?php
session_start();

include('includes/config.php');
if(strlen($_SESSION['alogin'])==0){
  // On le redirige vers la page de login
  header('location:../index.php');
  // Sinon on peut continuer. Apr�s soumission du formulaire de creation
} else {
  // récupération des catégories
  $sql="SELECT * FROM tblcategory WHERE Status = 1 ORDER BY id ASC";
  $query=$dbh->prepare($sql);
  $query->execute();
  $catresultats= $query->fetchAll(PDO::FETCH_OBJ);

  // récupération des auteurs
  $sql2="SELECT * FROM tblauthors ORDER BY id ASC";
  $query2=$dbh->prepare($sql2);
  $query2->execute();
  $autresultats= $query2->fetchAll(PDO::FETCH_OBJ);
    if (isset($_POST["addbook"])){
      // Récupération du titre, de la catégorie, de l'auteur, de l'ISBN et du prix
      $title = $_POST["title"];
      $isbn = $_POST["isbn"];
      $price = $_POST["price"];

      //Récupération du nom de la catégorie pour récupérer son identifiant 
      $category = $_POST["category"];
      $sql3="SELECT id FROM tblcategory WHERE CategoryName=:category";
      $query3 = $dbh->prepare($sql3);
      $query3->bindParam(':category', $category, PDO::PARAM_STR);
      $query3->execute();
      $resultid = $query3->fetch(PDO::FETCH_OBJ);
      $catid = $resultid->id;
    
      
      //Récupération du nom de l'auteur pour récupérer son identifiant 
      $author = $_POST["author"];
      $sql4="SELECT id FROM tblauthors WHERE AuthorName=:author";
      $query4 = $dbh->prepare($sql4);
      $query4->bindParam(':author', $author, PDO::PARAM_STR);
      $query4->execute();
      $resultid2 = $query4->fetch(PDO::FETCH_OBJ);
      $nameid = $resultid2->id;
     

      // On prepare la requete d'insertion dans la table tblbooks
      date_default_timezone_set('Europe/Paris');
      $DateAndTime = date('Y-m-d H:i:s', time());
      $sql5 = "INSERT INTO tblbooks (BookName, CatId, AuthorId, ISBNNumber, BookPrice, UpdationDate) VALUES (:title, :catid, :nameid, :isbn, :price, :DateAndTime)";
      $query5 = $dbh->prepare($sql5);
      $query5->bindParam(':title', $title, PDO::PARAM_STR);
      $query5->bindParam(':catid', $catid, PDO::PARAM_INT);
      $query5->bindParam(':nameid', $nameid, PDO::PARAM_INT);
      $query5->bindParam(':isbn', $isbn, PDO::PARAM_INT);
      $query5->bindParam(':price', $price, PDO::PARAM_STR);
      $query5->bindParam(':DateAndTime', $DateAndTime, PDO::PARAM_STR);
      // On execute la requete
      $query5->execute();
      // On stocke dans $_SESSION le message correspondant au resultat de loperation
      $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $_SESSION['msg']="Livre créé avec succès";
       header('location:manage-books.php');
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

    <title>Gestion de bibliothèque en ligne | Ajout de livres</title>
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
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Ajouter un livre</h4>
            </div>
		</div>
		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
                <form role="form" method="post" action="add-book.php">
							
							<div class="form-group">
							<label>Titre<i style="color:red">*</i></label>
							<input class="form-control" type="text" name="title" required autocomplete="on"  />
							</div>

              <div class="form-group">
              <label>Catégorie<i style="color:red">*</i></label>
              <select class="form-control" name="category" required>
                <?php
                if (is_array($catresultats)){
                  foreach ($catresultats AS $catresultat){ ?>
                <option><?php echo $catresultat->CategoryName ; ?></option>
                  <?php }
                 }
              ?>
              </select>
							</div>

              <div class="form-group">
							<label>Auteur<i style="color:red">*</i></label>
              <select class="form-control" name="author" required>
              <?php
                if (is_array($autresultats)){
                  foreach ($autresultats AS $autresultat){ ?>
              <option><?php echo $autresultat->AuthorName ; ?></option>
                  <?php }
                 }
              ?>
              </select>
							</div>

              <div class="form-group">
							<label>ISBN<i style="color:red">*</i></label>
							<input class="form-control" type="text" name="isbn" required autocomplete="on"  />
              <span style="color:red">Le numéro ISBN doit être unique.</span>
							</div>

              <div class="form-group">
							<label>Prix<i style="color:red">*</i></label>
							<input class="form-control" type="text" name="price" required autocomplete="on"  />
							</div>
						
							
							<button type="submit" name="addbook" class="btn btn-info">Créer</button>
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
