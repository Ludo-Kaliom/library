<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logu�
if(strlen($_SESSION['alogin'])==0) {   
	header('location:index.php');
} else { 
	if(isset($_POST['issue'])) {
		$readerid = strtoupper($_POST['readerid']);
		$bookid = $_POST['bookid'];
		$sql = "INSERT INTO tblissuedbookdetails(ReaderID, BookId, ReturnStatus) VALUES (:readerid, :bookid, 0)";
		$query = $dbh->prepare($sql);
		$query->bindParam(':readerid',$readerid,PDO::PARAM_STR);
		$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
		$query->execute();
		$lastInsertId = $dbh->lastInsertId();
		
		if($lastInsertId) {
			$_SESSION['msg']="la sortie a bien été enregistrée.";
			header('location:manage-issued-books.php');
		} else  {
			$_SESSION['error']="Une erreur s'est produite.";
			header('location:manage-issued-books.php');
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

<script>
// function for get reader name
function getreader(readerid) {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "get_reader.php?readerid="+readerid);
	xhr.responseType = "text";
	xhr.send();

	xhr.onload = function() {
		document.getElementById("get_reader_name").innerHTML = xhr.response;
	}
}

// function for book details
function getbook(bookid) {
	let xhr = new XMLHttpRequest();
	xhr.open("GET", "get_book.php?bookid="+bookid);
	xhr.responseType = "text";
	xhr.send();

	xhr.onload = function() {
		document.getElementById("get_book_name").innerHTML = xhr.response;
	}
}

</script> 

<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>


    <div class="content-wrapper">
    	<div class="container">
        	<div class="row pad-botm">
            	<div class="col-md-12">
                	<h4 class="header-line">Sortie d'un livre</h4>
                </div>
			</div>
			<div class="row">
				<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
					<div class="panel panel-info">
						<div class="panel-body">
							<form role="form" method="post">
								<div class="form-group">
									<label>Identifiant lecteur<span style="color:red;">*</span></label>
									<input class="form-control" type="text" name="readerid" id="readerid" onBlur="getreader(this.value)"   required />
								</div>
								<div class="form-group">
									<span id="get_reader_name" style="font-size:16px;"></span> 
								</div>
								<div class="form-group">
									<label>ISBN<span style="color:red;">*</span></label>
									<input class="form-control" type="text" name="bookid" id="bookid" onBlur="getbook(this.value)"  required />
								</div>
 								<div class="form-group">
  									<span id="get_book_name" style="font-size:16px;"></span>
								</div>
								<button type="submit" name="issue" id="submit" class="btn btn-info">Creer la sortie</button>
							</form>
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
