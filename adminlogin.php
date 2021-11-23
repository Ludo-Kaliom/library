<?php
// On demarre ou on recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// On invalide le cache de session $_SESSION['alogin'] = ''
if(isset($_SESSION['alogin']) && $_SESSION['alogin']!=''){
    $_SESSION['alogin'] = '';
}
// Apres la soumission du formulaire de login (plus bas dans ce fichier)
	// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
	// $_POST["vercode"] et la valeur initialis�e $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas
if(isset($_POST['alogin'])){
	if(!empty($_POST['vercode'])){
		if ($_SESSION['vercode'] != $_POST['vercode']){
			echo "<script> alert('Le code de vérification est invalide')</script>";
		} else {
            // Le code est correct, on peut continuer
            // On recupere le nom de l'utilisateur saisi dans le formulaire
			$name = $_POST['username'];
             // On recupere le mot de passe saisi par l'utilisateur et on le crypte (fonction md5)
			$password = $_POST['password'];
			$passwordmd5 = md5($password);
        // On construit la requete qui permet de retrouver l'utilisateur a partir de son nom et de son mot de passe
        // depuis la table admin
			$sql = "SELECT * FROM admin WHERE UserName LIKE :name AND Password LIKE :passwordmd5";
			$query = $dbh->prepare($sql);
			$query->bindParam(':name', $name, PDO::PARAM_STR);
			$query->bindParam(':passwordmd5', $passwordmd5, PDO::PARAM_STR);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
            
        	// Si le resultat de recherche n'est pas vide
            // On stocke le nom de l'utilisateur  $_POST['username'] en session $_SESSION
				if(!empty($result)){
				$_SESSION['alogin'] = $_POST['username'];
                // On redirige l'utilisateur vers le tableau de bord administration (n'existe pas encore)
				echo "<script> alert('login accepté')</script>";
                header('location:./admin/dashboard.php');
				} else {
                    // sinon le login est refuse. On le signal par une popup
					echo "<script> alert('login refusé')</script>";
				}
		}
	}

}

        

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne</title>
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

<div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Connexion Administration</h4>
				<span>
				Compte démonstration Administrateur<br>
				Login : admin@admin.com<br>
				Mot de passe : admin
				</span>
            </div>
		</div>
		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
				<form name="form" method="post" action="adminlogin.php">
						<div class="form-group">
						<label>Votre nom</label>
						<input class="form-control" placeholder="Nom" type="text" name="username" required />
						</div>

						<div class="form-group">
						<label>Votre mot de passe</label>
						<input class="form-control" placeholder="Mot de passe" type="text" name="password" required /><br>
						</div>

						<div class="form-group">
						<label>Code de vérification : <img src="captcha.php"></label>
						<input class="form-control" type="text" placeholder="Entrez le code de vérification" name="vercode" required />
						</div>

						<button type="submit" name='alogin' class="btn btn-info">Login</button>
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
