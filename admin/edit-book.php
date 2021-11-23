<?php
session_start();

include('includes/config.php');


if(strlen($_SESSION['alogin'])==0){
      // On le redirige vers la page de login
      header('location:../index.php');
      // Sinon on peut continuer. Apr�s soumission du formulaire de creation
    } else {
      // récupération des catégories
      $sql="SELECT CategoryName, id FROM tblcategory ORDER BY id ASC";
      $query=$dbh->prepare($sql);
      $query->execute();
      $catresultats= $query->fetchAll(PDO::FETCH_OBJ);

      // récupération des auteurs
      $sql2="SELECT * FROM tblauthors ORDER BY id ASC";
      $query2=$dbh->prepare($sql2);
      $query2->execute();
      $autresultats= $query2->fetchAll(PDO::FETCH_OBJ);

      //récupération des informations envoyées par Get
      $bookid = intval($_GET['bookid']);

      // requête pour récupérer les éléments liés à l'identifiant du livre
      $sql3="SELECT * FROM tblbooks WHERE id=:bookid";
      $query3=$dbh->prepare($sql3);
      $query3->bindParam(':bookid', $bookid, PDO::PARAM_INT);
      $query3->execute();
      $resultats= $query3->fetch(PDO::FETCH_OBJ);

            if (isset($_POST["update"])){
                  // Récupération du titre, de la catégorie, de l'auteur, de l'ISBN et du prix
                  $bookid = intval($_GET['bookid']);
                  $title = $_POST["title"];
                  $isbn = $_POST["isbn"];
                  $price = $_POST["price"];
                  $catid = $_POST['category'];
                  $authorid = $_POST['author'];

                  // On prepare la requete d'insertion dans la table tblbooks
                  $sql4 ="UPDATE tblbooks SET BookName=:title, CatId=:catid, AuthorId=:authorid, ISBNNumber=:isbn, BookPrice=:price WHERE id=:bookid";
                  $query4 = $dbh->prepare($sql4);
                  $query4->bindParam(':title', $title, PDO::PARAM_STR);
                  $query4->bindParam(':catid', $catid, PDO::PARAM_INT);
                  $query4->bindParam(':authorid', $authorid, PDO::PARAM_INT);
                  $query4->bindParam(':isbn', $isbn, PDO::PARAM_STR);
                  $query4->bindParam(':price', $price, PDO::PARAM_STR);
                  $query4->bindParam(':bookid', $bookid, PDO::PARAM_INT);
                  // On execute la requete
                  $query4->execute();
                  // On stocke dans $_SESSION le message correspondant au resultat de loperation $lastInsertId = $dbh->lastInsertId();
                 
                  $_SESSION['msg'] = "Le livre a été modifié avec succès";
                  header('location:manage-books.php');

            }
    }

?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Livres</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <!-- link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' / -->
</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->

<div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Editer un livre</h4>
                </div>
            </div>
        </div>

        <!-- On affiche le formulaire de creation-->

	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-12 offset-md-3" >
                  <div class="panel panel-info">
                  Information livre
				<div class="panel-body">
                        <?php
                              if (!empty($resultats)) {
                        ?>
					<form role="form" method="post">
							
                                    <div class="form-group">
                                          <label>Titre<i style="color:red">*</i></label>
                                          <input class="form-control" type="text" name="title" value="<?php echo $resultats->BookName ;?>" required autocomplete="on"  />
                                    </div>

                                    <div class="form-group">
                                          <label>Catégorie<i style="color:red">*</i></label>
                                          <select class="form-control" name="category">
                                          <option value="">Choisir une catégorie</option>
                                          <?php
                                                if (is_array($catresultats)){
                                                foreach ($catresultats AS $catresultat){ ?>
                                                <option value="<?php echo $catresultat->id?>"> <?php echo $catresultat->CategoryName ?></option>
                                          <?php 
                                                }
                                          }
                                          ?>
                                          </select>
                                    </div>

                                    <div class="form-group">
                                          <label>Auteur<i style="color:red">*</i></label>
                                          <select class="form-control" name="author">
                                          <option value="">Choisir un auteur</option>
                                          <?php
                                                if (is_array($autresultats)){
                                                foreach ($autresultats AS $autresultat){ ?>
                                                <option value="<?php echo $autresultat->id?>"> <?php echo $autresultat->AuthorName ?></option>
                                          <?php 
                                                }
                                          }
                                          ?>
                                          </select>
                                    </div>

                                    <div class="form-group">
                                          <label>ISBN<i style="color:red">*</i></label>
                                          <input class="form-control" type="text" name="isbn" value="<?php echo $resultats->ISBNNumber ;?>"required autocomplete="on"  />
                                          <span style="color:red">Le numéro ISBN doit être unique.</span>
                                    </div>

                                    <div class="form-group">
                                          <label>Prix<i style="color:red">*</i></label>
                                          <input class="form-control" type="text" name="price" value="<?php echo $resultats->BookPrice ;?>" required autocomplete="on"  />
                                          </div>
                                                            
                                                                  
                                    <button type="submit" name="update" class="btn btn-info">Mettre à jour</button>
					</form>
                              <?php } ?>
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
