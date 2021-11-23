<?php
// On r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');
if(isset($_POST['signup'])){
    // On vérifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
	// $_POST["vercode"] et la valeur initialis�e $_SESSION["vercode"] lors de l'appel � captcha.php (voir plus bas
	if(!empty($_POST['vercode'])){
		if ($_SESSION['vercode'] != $_POST['vercode']){
			echo "<script> alert('Le code de vérification est invalide')</script>";
		} else {
            //On lit le contenu du fichier readerid.txt au moyen de la fonction file. Ce fichier contient le dernier identifiant lecteur cree.
            $hits = file("readerid.txt");
            // On incrémente de 1 la valeur lue
            $hits[0]++;
            // On ouvre le fichier readerid.txt en écriture
            if (true === file_exists("readerid.txt")){
                $fp = fopen("readerid.txt", "w");
                // On écrit dans ce fichier la nouvelle valeur
                fputs($fp,"$hits[0]");
                // On referme le fichier
                fclose($fp);
                // On récupère le nom saisi par le lecteur
                $fname = $_POST["fullname"];
                // On récupère le numéro de portable
                $mobilno = $_POST["mobileno"];
                 // On récupère l'email
                $email = $_POST["email"];
                // On récupère le mot de passe
                $password = md5($_POST["password"]);
                // On fixe le statut du lecteur à 1 par défaut (actif)
                $status = 1;
                // On pr�pare la requete d'insertion en base de donn�e de toutes ces valeurs dans la table tblreaders
                $sql = "INSERT INTO tblreaders (ReaderId, FullName, MobileNumber, EmailId, Password1, Status) VALUES (:ReaderId, :FullName, :MobileNumber, :EmailId, :Password1, :Status)";
			    $query = $dbh->prepare($sql);
                $query->bindParam(':ReaderId', $hits[0], PDO::PARAM_STR);
                $query->bindParam(':FullName', $fname, PDO::PARAM_STR);
                $query->bindParam(':MobileNumber', $mobilno, PDO::PARAM_STR);
			    $query->bindParam(':EmailId', $email, PDO::PARAM_STR);
			    $query->bindParam(':Password1', $password, PDO::PARAM_STR);
                $query->bindParam(':Status', $status, PDO::PARAM_STR);
                // On execute la requete
                $query->execute();
                // On r�cup�re le dernier id insère en bd (fonction lastInsertId)
                $lastInsert = $dbh->lastInsertId();
                // Si ce dernier id existe, on affiche dans une pop-up que l'opération s'est bien déroulée, et on affiche l'identifiant lecteur (valeur de $hit[0])
                if($lastInsert !== FALSE){
                    echo "<script> alert('Vous êtes enregistré avec succès, votre ID est ".$hits[0]."')</script>";
                } else {
                    // Sinon on affiche qu'il y a eu un probléme
                    echo "<script> alert('Un problème est survenu')</script>";
                }
            } else {
                echo "<script> alert('fichier readerid.txt absent')</script>";
            }
        }
    }
}

error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang = "FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <title>Gestion de bibliotheque en ligne | Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />

<!-- <script type="text/javascript" src="main.js"></script> -->

<script type="text/javascript">

    // On cree une fonction valid()  de validation sans paramétre qui renvoie 
  function valid() {
        let password = document.getElementById("password");
        let checkPassword = document.getElementById("check-password");
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
            checkPassword.focus();
            return false;
    }
}


function checkAvailability(str){
    let xhr = new XMLHttpRequest();
    xhr.open("GET","check_availability.php?emailId=" + str);
    xhr.responseType = "text";
    xhr.send();

    xhr.onload = function() {
        document.getElementById('user-availability-status').innerHTML = xhr.response;
    }
    xhr.onerror = function (){
        alert ("Une erreur s'est produite");
    }
}

    </script>

</head>
<body>

 <!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php');?>
<div class="content-wrapper">
         <div class="container">
        	<div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Créer un compte</h4>
            </div>
		</div>
		<div class="row">
			<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
				<div class="panel panel-info">
        <form name="signup" method="post">
                <div>
                    <label>Entrez votre nom complet</label>
                    <input class="form-control" type="text" name="fullname" required />
                </div>
                <div>
                    <label>Portable :</label>
                    <input class="form-control" type="text" name="mobileno" maxlength="10"  required />
                </div>
                            
                <div>
                    <label>Email :</label>
                    <input class="form-control" type="email" name="email" id="emailId" onBlur="checkAvailability(this.value)"  required  />
                    <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>

                <div>
                    <label>Mot de passe :</label>
                    <input class="form-control" type="password" name="password" id="password" required  />
                </div>
                <div >
                    <label>Confirmez le mot de passe :</label>
                    <input class="form-control"  type="password" name="confirmpassword" id="check-password" onBlur="return valid()" required  />
                </div>
                
                <span id="message"></span>
                
                <div>
                    <label>Code de verification :</label>
                    <input type="text"  name="vercode" maxlength="5" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
                </div>                                
                <button type="submit" name="signup" class="btn btn-danger" id="submit">Enregistrer</button>
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
