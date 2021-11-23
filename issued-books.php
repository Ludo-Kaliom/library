<?php
// On r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// Si l'utilisateur n'est pas connecte, on le dirige vers la page de login
if(strlen($_SESSION['rdid'])==0) {
	
  header('location:index.php');
}else{
// Sinon on peut continuer

$sid =$_SESSION['rdid'];

$sql="SELECT tblbooks.BookName, tblbooks.ISBNNumber, tblissuedbookdetails.IssuesDate, tblissuedbookdetails.ReturnDate, tblissuedbookdetails.id
FROM tblissuedbookdetails
JOIN tblbooks ON tblissuedbookdetails.BookId=tblbooks.ISBNNumber
WHERE ReaderID=:sid
ORDER BY tblissuedbookdetails.id DESC";
$query=$dbh->prepare($sql);
$query->bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$resultats= $query->fetchAll(PDO::FETCH_OBJ);


?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Gestion des livres</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
      <!--On insere ici le menu de navigation T-->
<?php include('includes/header.php');?>
<div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Livres sortis</h4>
            </div>
		</div>

		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
                <div class="row">
                <div class="col">
                <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titre</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Date de sortie</th>
                            <th scope="col">Date de retour</th>
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
                                <td> <?php echo $result-> BookName; ?></td>
                                <td><?php echo $result-> ISBNNumber; ?></td>
                                <td><?php echo $result-> IssuesDate; ?></td>
                            
                                <td>
                                <?php if($result->ReturnDate ==""){
                                    ?>
                                    <span style="color:red"> 
                                        Non retourné
                                    </span>
                                <?php } else {
                                    echo $result->ReturnDate;
                                    }
                                ?>
                                </td>
                                </tr>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>