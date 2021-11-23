<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');


// Si l'utilisateur n'est pas logue, on le redirige vers la page de login (index.php)
if(empty($_SESSION['login'])){
	header('location:index.php');
	// sinon, on peut continuer,
} else {
	// si le formulaire a ete envoye : $_POST['change'] existe
	if (isset($_POST["change"])){
		//On recupere le mot de passe et on le crypte (fonction md5)
		$password = md5($_POST["password"]);
		//On recupere le nouveau mot de passe et on le crypte
		$npassword = md5($_POST["npassword"]);
		//On recupere l'email de l'utilisateur dans le tabeau $_SESSION
		$email = $_SESSION["login"];
		//On cherche en base l'utilisateur avec ce mot de passe et cet email
		$sql = "SELECT * FROM tblreaders WHERE EmailId=:email AND Password1=:password";
		$query = $dbh->prepare($sql);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam('password', $password, PDO::PARAM_STR);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		// Si le resultat de recherche n'est pas vide
		if (!empty($result)){
			// On met a jour en base le nouveau mot de passe (tblreader) pour ce lecteur
			$sql1 = "UPDATE tblreaders SET Password1=:npassword WHERE EmailId=:email";
			$query1 = $dbh->prepare($sql1);
			$query1->bindParam(':email', $email, PDO::PARAM_STR);
			$query1->bindParam(':npassword', $npassword, PDO::PARAM_STR);
			$query1->execute();
			// On stocke le message d'operation reussie
			echo "<script> alert('Mot de passe changé')</script>";
			$succes = "Mot de passe changé";
			//sinon (resultat de recherche vide)
			} else {
				//On stocke le message "mot de passe invalide"
			echo "<script> alert('Le mot de passe n'a pas pu être changé')</script>";
			$echec = "Le mot de passe n'a pas été changé";
			}
		}	
	}


?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | changement de mot de passe</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    
    <!-- Penser au code CSS de mise en forme des message de succes ou d'erreur -->

</head>
<script type="text/javascript">

// On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques -->
// Cette fonction retourne un booleen

function valid() {
        let password = document.getElementById("npassword");
        let checkPassword = document.getElementById("check-npassword");
        let message = document.getElementById("message");
        let button = document.getElementById("submit");

        if (password.value === checkPassword.value) {
            message.style.color = "green"
            message.innerHTML = "Les mots de passe sont identiques.";
            button.disabled = false;
            return true;
        } else {
            message.style.color = "red"
            message.innerHTML = "Les mots de passe ne sont pas identiques.";
            button.disabled = true;
            return false;
    }
}

</script>

<body>
<!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
<?php include('includes/header.php');?>
<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 offset-md-3" >
			<div class="row pad-botm">
			<div class="col-md-12">
				<h4 class="header-line">Changer le mot de passe</h4>
			</div>
		</div>


				<div class="panel panel-info">
					<div class="panel-body">
                    <form role="form" name="change" method="post" onSubmit="return valid();">
							
							<div class="form-group">
							<label>Mot de passe actuel</label>
							<input class="form-control" type="password" name="password" id="password" required autocomplete="on"  />
							</div>
							
							<div class="form-group">
							<label>Nouveau mot de passe</label>
							<input class="form-control" type="password" name="npassword" id="npassword" required autocomplete="off"  />
							</div>

							<div class="form-group">
							<label>Confirmer le nouveau mot de passe</label>
							<input class="form-control" type="password" name="check-npassword" id="check-npassword" required autocomplete="off" onkeyup="return valid()" />
							<span id="message"></span>
							</div>
							
							<button type="submit" name="change" class="btn btn-info">Changer le mot de passe</button>
						</form>
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
