<?php 
require_once("includes/config.php");
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero l'identifiant du lecteur SID---*/
if(!empty($_GET["readerid"])){
	$readerid = $_GET["readerid"];
	
	// On prepare la requete de recherche du lecteur correspondant
	$sql="SELECT * FROM tblreaders WHERE ReaderId=:readerid";
	$query=$dbh->prepare($sql);
	$query->bindParam(':readerid', $readerid, PDO::PARAM_STR);
	$query->execute();
	$result= $query->fetch(PDO::FETCH_OBJ);

    // Si le resultat de recherche n'est pas vide
	if(!empty($result)) {
		// Si le statut du lecteur est 0
		if($result->Status==0) { // Inactif
			// On signale a l'utilisateur que "ce lecteur est bloque"
			echo "<span style='color:red'>Ce lecteur bloque </span>"."<br />";
			// On affiche son nom complet
			echo "<b>Nom : </b>" .$result->FullName;
			// On desactive le bouton d'envoi du formulaire
 			echo "<script>document.getElementById('submit').disabled = true;</script>";
 		// Sinon si le statut du lecteur est 2
		} elseif ($result->Status==1) { // Actif
		// Sinon
			// On affiche le nom complet du lecteur
			echo ($result->FullName);
			// On active le bouton d'envoi du formulaire
			echo "<script>document.getElementById('submit').disabled = false;</script>";
		} else { // Supprime mais toujours en BD
			// On signale a l'utilisateur que "Le compte de ce lecteur est supprime"
			echo "Le compte de : ".$result->FullName . " a ete supprime !";
			// On desactive le bouton d'envoi du formulaire
			echo "<script>document.getElementById('submit').disabled = true;</script>";
		}
	} else { // resultat vide --> Le lecteur nexiste pas en base
		// On signale a l'utilisateur que "Le compte de ce lecteur est supprime"
		echo "Le lecteur n'existe pas !";
		// On desactive le bouton d'envoi du formulaire
		echo "<script>document.getElementById('submit').disabled = true;</script>";
	}
} else {
	// sinon (l'identifiant dans l'url est vide)
	echo "<span style='color:red'>Identifiant du lecteur non valide</span>";
	// On desactive le bouton d'envoi du formulaire
 	echo "<script>document.getElementById('submit').disabled = true;</script>";
}



?>
