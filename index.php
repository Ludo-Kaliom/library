<?php
// On demarre ou on recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donnees
include('includes/config.php');
// On invalide le cache de session
if(isset($_SESSION['login']) && $_SESSION['login']!='') {
	$_SESSION['login'] = '';
}

if(isset($_POST['login'])){
	if(!empty($_POST['vercode'])){
		if ($_SESSION['vercode'] != $_POST['vercode']){
			echo "<script> alert('Le code de vérification est invalide')</script>";
		} else {
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			$sql = "SELECT * FROM tblreaders WHERE EmailID LIKE :email AND Password1 LIKE :password";
			$query = $dbh->prepare($sql);
			$query->bindParam(':email', $email, PDO::PARAM_STR);
			$query->bindParam(':password', $password, PDO::PARAM_STR);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_OBJ);
				if(!empty($result)){
				$_SESSION['rdid'] = $result->ReaderId;
				}
				if ($result -> Status ==1){
					$_SESSION['login'] = $_POST['email'];
					header('location:dashboard.php');
					} else {
					echo "<script> alert('Compte bloqué')</script>";
				}
		}echo "<script> alert('utilisateur inconnu')</script>";
	}

}

?>
<!DOCTYPE html>
<html lang="FR">
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
     <!--On inclue ici le menu de navigation includes/header.php-->
<?php include('includes/header.php');?>

<div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Connexion utilisateur</h4>
				<span>Compte démonstration utilisateur<br>
				Login : User@user.com<br>
				Mot de passe : User</span>
            </div>
		</div>
		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
        	<form name="form" method="post" action="index.php">

				<div class="form-group">
				<label >Entrez votre email</label>
				<input type="email" class="form-control" placeholder="Nom" name="email" required />
				</div>

				<div class="form-group">
				<label >Mot de passe</label>
				<input type="password" class="form-control" placeholder="Mot de passe" name="password" required />
				<a href="change-password.php">Mot de passe oublié</a><br>
				</div>

				<div class="form-group">
				<label >Code de vérification : <img src="captcha.php"></label>
				<input type="text" class="form-control" placeholder="Entrez le code de vérification" name="vercode" required />
				</div>
				<button type="submit" name='login'  class="btn btn-info">Login</button>
				<a href="signup.php">Je n'ai pas de compte</a>
        	</form>
            
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
