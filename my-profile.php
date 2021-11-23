<?php 
// On r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

if(strlen($_SESSION['login'])==0) {
	// Si l'utilisateur n'est plus logu�
    // On le redirige vers la page de login
  header('location:index.php');
    } else {
        if(isset($_POST['profile'])) {
        // Sinon on peut continuer. Apr�s soumission du formulaire de profil
    	// On recupere l'id du lecteur (cle secondaire)
        $sid = $_SESSION['rdid'];
        // On recupere le nom complet du lecteur
        $name = $_POST["fullname"];
        // On recupere le numero de portable
        $mobileno = $_POST["mobileno"];
        // On recupere l'email du lecteur
        $mail = $_POST["email"];
        // On update la table tblreaders avec ces valeurs
        $req="UPDATE tblreaders SET FullName=:name, MobileNumber=:mobileno, EmailId=:mail WHERE ReaderId=:sid";
			$update = $dbh->prepare($req);
			$update-> bindParam(':name', $name, PDO::PARAM_STR);
			$update-> bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
			$update-> bindParam(':mail', $mail, PDO::PARAM_STR);
            $update-> bindParam(':sid', $sid, PDO::PARAM_STR);
			$update->execute();
        // On informe l'utilisateur du resultat de l'operation
        echo "<script>alert('Informations mises à jour');</script>";
        }
    }


	// On souhaite voir la fiche de lecteur courant.
    // On recupere l'id de session dans $_SESSION
    $sid = $_SESSION['rdid'];
	// On prepare la requete permettant d'obtenir
    $sql = "SELECT * FROM tblreaders WHERE ReaderId LIKE :sid";
	$query = $dbh->prepare($sql);
	$query->bindParam(':sid', $sid, PDO::PARAM_STR);
	$query->execute();
    $result = $query->fetch();
    $fullname = $result["FullName"];
    $email = $result["EmailId"];
    $mobileno = $result["MobileNumber"];
    $regdate = $result["RegDate"];
    $updatedate = $result["UpdateDate"];
    $status =$result["Status"];
    if ($status == 1){
        $status1 = "Actif";
    } else if ($status == 0) {
        $status1 = "Inactif";
    } else if ($status == 3) {
        $status1 = "Supprimé";
    }




?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Profil</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />

</head>
<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php');?>
<!--On affiche le titre de la page : EDITION DU PROFIL-->
<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 offset-md-3" >
			    <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Mon compte</h4>
                    </div>
		        </div>
                <div class="col-md-12">
                    <span>Identifiant : <?php echo "$sid" ?><br></span>
                    <span>Date d'enregistrement : <?php echo $regdate ?><br></span>
                    <span>Dernière mise à jour : <?php echo $updatedate ?><br></span>
                    <span>Statut : <?php echo $status1 ?></span>
                </div>

			        <div class="panel-body">	
                    <form name="profile" method="post" action="my-profile.php" >
                
                    <div>
                    <label>Nom complet</label>
                    <input class="form-control" type="text" name="fullname" value="<?php echo $fullname ?>" required />
                    </div>

                    <div>
                    <label>Portable :</label>
                    <input class="form-control" type="text" name="mobileno" maxlength="10" value="<?php echo $mobileno ?>"  required />
                    </div>
                            
                    <div>
                    <label>Email :</label>
                    <input class="form-control" type="email" name="email" id="emailId" value="<?php echo $email ?>"  required  /> 
                    </div>

                         
                    <button type="submit" name="profile" class="btn btn-danger" id="submit">Mettre à jour</button>
                    </form>
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
