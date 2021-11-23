<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
	header('location:../index.php');
} else { 
        $sql="SELECT id, CategoryName, Status, CreationDate, UpdationDate FROM tblcategory ORDER BY id ASC";
        $query=$dbh->prepare($sql);
        $query->execute();
        $resultats= $query->fetchAll(PDO::FETCH_OBJ);
        
	if(isset($_GET['del'])) {
        // On recupere l'identifiant de la cat�gorie a supprimer
        $delete = $_GET["del"];
		// On prepare la requete de suppression
        $del = "DELETE FROM tblcategory WHERE id=:delete";
		$query1 = $dbh->prepare($del);
		$query1->bindParam(':delete', $delete, PDO::PARAM_INT);
        // On execute la requete
		$query1->execute();
		// On informe l'utilisateur du resultat de loperation
        $_SESSION['delmsg']="La catégorie est bien supprimée";
		// On redirige l'utilisateur vers la page manage-categories.php
        header('location:manage-categories.php');
	}
}
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion categories</title>
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
                <h4 class="header-line">Gestion des catégories</h4>
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
                            <th scope="col">Nom</th>
                            <th scope="col">Status</th>
                            <th scope="col">Créé le </th>
                            <th scope="col">Mise à jour le</th>
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
                                    <td> <?php echo $result-> CategoryName; ?></td>
                                    <td><?php
                                    if ($result->Status ==0) {
                                       echo "<button type='button' class='btn btn-danger'>Inactive</button>";
                                    } else {
                                        echo "<button type='button' class='btn btn-success'>Active</button>";
                                    }
                                    
                                    ?></td>
                                    <td><?php echo $result-> CreationDate; ?></td>
                                    <td><?php echo $result-> UpdationDate; ?></td>
                                    <td>

                                    <a href="edit-category.php?catid=<?php echo $result->id ?>">
                                    <button class="btn btn-primary">Editer</button>
                                </a>
                                <a href="manage-categories?del=<?php echo $result->id ?>" onClick="return confirm('Etes-vous sûr ?')">
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
     

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>






















