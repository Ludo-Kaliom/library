<?php 
require_once("includes/config.php");
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero ISBN du livre*/
if(!empty($_GET["bookid"])){
	$isbn = $_GET["bookid"];
	// On prepare la requete de recherche de l'ISBN correspondant
	$sql1="SELECT * FROM tblbooks WHERE ISBNNumber=:isbn";
	$query1=$dbh->prepare($sql1);
	$query1->bindParam(':isbn', $isbn, PDO::PARAM_INT);
	$query1->execute();
	$result1= $query1->fetch(PDO::FETCH_OBJ);

	// Si le resultat de recherche n'est pas vide
	if(!empty($result1)) {
		// On affiche le titre du livre
		echo $result1->BookName;
		// On active le bouton d'envoi du formulaire
		echo "<script>document.getElementById('submit').disabled = false;</script>";
	} else {
// Sinon (pas ISBN)
	// On informe l'utilisateur
	echo "ISBN non valide";
	// On d�sactive le bouton d'envoi du formulaire
	echo "<script>document.getElementById('submit').disabled = true;</script>";
	}
}

?>
