<?php
session_start();
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
	header('location:../index.php');
} else { 
        $sql="SELECT tblbooks.id, BookName, ISBNNumber,BookPrice, tblcategory.CategoryName, tblauthors.AuthorName
        FROM tblbooks, tblauthors, tblcategory
        WHERE tblbooks.CatId=tblcategory.id
        AND tblbooks.AuthorId=tblauthors.id";
        $query=$dbh->prepare($sql);
        $query->execute();
        $resultats= $query->fetchAll(PDO::FETCH_OBJ);
        
	if(isset($_GET['del'])) {
            // On recupere l'identifiant de la cat�gorie a supprimer
            $delete = $_GET["del"];
            // On prepare la requete de suppression
            $del = "DELETE FROM tblbooks WHERE id=:delete";
            $query1 = $dbh->prepare($del);
            $query1->bindParam(':delete', $delete, PDO::PARAM_INT);
            // On execute la requete
            $query1->execute();
            // On informe l'utilisateur du resultat de loperation
            $_SESSION['delmsg']="L'auteur a bien supprimé";
            // On redirige l'utilisateur vers la page manage-books.php
            header('location:manage-books.php');
	}
}

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion livres</title>
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

<div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Gestion des livres</h4>
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
                            <th scope="col">Titre</th>
                            <th scope="col">Catégorie</th>
                            <th scope="col">Nom de l'auteur</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Prix</th>
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
                                    <td><?php echo $result->BookName; ?></td>
                                    <td><?php echo $result->CategoryName ?></td>
                                    <td><?php echo $result->AuthorName; ?></td>
                                    <td><?php echo $result->ISBNNumber; ?></td>
                                    <td><?php echo $result->BookPrice; ?></td>
                                    <td>

                                    <a href="edit-book.php?bookid=<?php echo $result->id ?>">
                                    <button class="btn btn-primary">Editer</button>
                                </a>
                                <a href="manage-books?del=<?php echo $result->id ?>" onClick="return confirm('Etes-vous sûr ?')">
                                    <button class="btn btn-danger">Supprimer</button>
                                </a>
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

<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
