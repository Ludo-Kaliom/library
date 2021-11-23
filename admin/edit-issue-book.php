<?php
session_start();

include('includes/config.php');

error_log("POST :".print_r($_POST, 1));
error_log("GET :".print_r($_GET, 1));

if(strlen($_SESSION['alogin'])==0) {   
	header('location:index.php');
} else { 
	$rid = intval($_GET['rid']);
	$sql = "SELECT tblreaders.FullName,
				tblbooks.BookName,
				tblbooks.ISBNNumber,
				tblissuedbookdetails.IssuesDate,
				tblissuedbookdetails.ReturnDate,
				tblissuedbookdetails.id as rid,
				tblissuedbookdetails.ReturnStatus
			from tblissuedbookdetails
			join tblreaders on tblreaders.ReaderId=tblissuedbookdetails.ReaderId
			join tblbooks on tblbooks.ISBNNumber=tblissuedbookdetails.BookId
			where tblissuedbookdetails.id=:rid";
	$query = $dbh -> prepare($sql);
	$query->bindParam(':rid',$rid,PDO::PARAM_STR);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	error_log("RESULT :".print_r($result, 1));

	if(isset($_POST['return'])) {
		$rDate = $_POST['returnDate'];
		$rStatus = 1;
		$sql = "UPDATE tblissuedbookdetails SET ReturnDate=:rdate,ReturnStatus=:rstatus WHERE id=:rid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':rid',$rid,PDO::PARAM_STR);
		$query->bindParam(':rdate',$rDate,PDO::PARAM_STR);
		$query->bindParam(':rstatus',$rStatus,PDO::PARAM_STR);
		$query->execute();

		$_SESSION['msg']="Le livre a bien ete rendu";
		header('location:manage-issued-books.php');
	}
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Sorties</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</style>

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Editer la sortie</h4>
            </div>
		</div>
		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
					<div class="panel-heading">
					</div>
					<?php 

						if(!empty($result)) {
					?>
					<div class="panel-body">
						<form role="form" method="post">
							<div class="form-group">
								<label>Lecteur : </label>
								<?php echo $result->FullName;?>
							</div>
							<div class="form-group">
								<label>Titre : </label>
								<?php echo $result->BookName;?>
							</div>
							<div class="form-group">
								<label>ISBN : </label>
								<?php echo $result->ISBNNumber;?>
							</div>
							<div class="form-group">
								<label>Sorti le : </label>
								<?php echo $result->IssuesDate;?>
							</div>
							<div class="form-group">
								<label>Retourné le : </label>
								<?php if($result->ReturnDate=="") {
                                      		echo "Non retourne";
                                      } else {
											echo $result->ReturnDate;
									  }
								?>
							</div>
							<div class="form-group">
								<label>Date de retour (AAAA-MM-JJ): </label>
								<?php
								if($result->ReturnDate == "") { ?>
									<input class="form-control" type="text" name="returnDate" id="fine" />
								<?php
								} else {
									echo $result->ReturnDate;
								}?>
							</div>
							<button type="submit" name="return" id="submit" class="btn btn-info">Envoyer</button>
						</form>
 					</div>
					<?php } // fin de if empty result?>            
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
<?php //} ?>
