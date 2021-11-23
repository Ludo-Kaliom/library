<?php 

// On inclue le fichier de configuration et de connexion a la base de donnees
require_once("includes/config.php");

if(!empty($_GET["emailId"])){
	$email = $_GET["emailId"];
	if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){
		echo "email invalide";
	}else{
	$sql = "SELECT EmailId FROM tblreaders WHERE EmailId=:email";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);
		// Si le resultat n'est pas vide. On signale a l'utilisateur que cet email existe deja et on desactive le bouton de soumission du formulaire//
		if(!empty($result)){
			echo "<span style='color:red'>Cet email existe déjà</span>";
			// echo '<input type="button" id="button" disabled="disabled" />';
		}else{
			// Sinon on signale a l'utlisateur que l'email est disponible et on active le bouton du formulaire
			echo "<span style='color:red'>Cet email est disponible</span>";
			// echo '<input type="button" id="button" />';
		}
	}
}


?>
