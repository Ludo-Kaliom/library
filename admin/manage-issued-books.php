<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
	header('location:../index.php');
} else {
	$sql = "SELECT tblreaders.FullName,
					tblbooks.BookName,
					tblbooks.ISBNNumber,
					tblissuedbookdetails.IssuesDate,
					tblissuedbookdetails.ReturnDate,
					tblissuedbookdetails.id as rid
			from tblissuedbookdetails
			join tblreaders on tblreaders.ReaderId=tblissuedbookdetails.ReaderId
			join tblbooks on tblbooks.ISBNNumber=tblissuedbookdetails.BookId
			order by tblissuedbookdetails.id desc";
	$query = $dbh -> prepare($sql);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
}



?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion des sorties</title>
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
                <h4 class="header-line">Gestion des sorties</h4>
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
                <table class="table table-striped table-bordered table-hove" id="dataTables-example">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Lecteur</th>
                                            <th>Titre</th>
                                            <th>ISBN</th>
                                            <th>Sortie le</th>
                                            <th>Retourne le</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php

										if(count($results) > 0) {
											$cnt =1;
											
											foreach($results as $result) {?>                                   
                                        <tr class="">
                                        <!-- <tr class="odd gradeX"> -->
                                            <td class="center"><?php echo $cnt;?></td>
                                            <td class="center"><?php echo $result->FullName;?></td>
                                            <td class="center"><?php echo $result->BookName;?></td>
                                            <td class="center"><?php echo $result->ISBNNumber;?></td>
                                            <td class="center"><?php echo $result->IssuesDate;?></td>
                                            <td class="center"><?php if($result->ReturnDate=="") {
                                                echo "Non retourne";
                                            } else {
                                            	echo $result->ReturnDate;
											}
                                            ?>
                                            </td>
                                            <td class="center">
                                            	<a href="edit-issue-book.php?rid=<?php echo $result->rid;?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Editer</button></a>
                                            </td>
                                        </tr>
 										<?php $cnt++;
											} // Fin boucle foreach
										} // Fin condition tableau non vide ?>                                      
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

