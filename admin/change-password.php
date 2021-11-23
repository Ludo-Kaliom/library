<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logu�
// On le redirige vers la page de login
if(strlen($_SESSION['alogin'])==0){
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
  header('location:../index.php');

} else { 

	// Sinon on peut continuer. Apr�s soumission du formulaire de modification du mot de passe
	// Si le formulaire a bien ete soumis
	if (isset($_POST["change"])){
		// On recupere le mot de passe courant
		$password = md5($_POST["password"]);
		// On recupere le nouveau mot de passe
		$npassword = md5($_POST["npassword"]);
		// On recupere le nom de l'utilisateur stock� dans $_SESSION
		$username = $_SESSION["alogin"];
		// On prepare la requete de recherche pour recuperer l'id de l'administrateur (table admin)
		// dont on connait le nom et le mot de passe actuel
		$sql = "SELECT * FROM admin WHERE UserName=:username AND Password=:password";
		$query = $dbh->prepare($sql);
		$query->bindParam(':username', $username, PDO::PARAM_STR);
		$query->bindParam('password', $password, PDO::PARAM_STR);
		// On execute la requete
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		if (!empty($result)){
			// Si on trouve un resultat
			// On prepare la requete de mise a jour du nouveau mot de passe de cet id
			$sql1 = "UPDATE admin SET Password=:npassword WHERE UserName=:username";
			$query1 = $dbh->prepare($sql1);
			$query1->bindParam(':username', $username, PDO::PARAM_STR);
			$query1->bindParam(':npassword', $npassword, PDO::PARAM_STR);
			// On execute la requete
			$query1->execute();
			// On stocke un message de sussces de l'operation
			$_SESSION['updatemsg'] = "Le mot de passe a été mis à jour";
			//sinon (resultat de recherche vide)
			} else {	
			// On stocke un message d'erreur
			$_SESSION['error'] = "Le mot de passe n'a pas été changé";
			}
			
	}

}

		
		
	

?>

<!DOCTYPE html>
<html lang = "FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- Penser a mettre dans la feuille de style les classes pour afficher le message de succes ou d'erreur  -->
</head>

<script>
// On cree une fonction JS return valid() qui renvoie
// true si les mots de passe sont identiques
// false sinon
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
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->

<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 offset-md-3" >
			<div class="row pad-botm">
			<div class="col-md-12">
				<h4 class="header-line">Changer le mot de passe</h4>
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
							
							<button type="submit" name="change" id="submit" class="btn btn-info">Changer le mot de passe</button>
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
