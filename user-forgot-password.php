<?php
session_start();

include('includes/config.php');

if(isset($_POST['change'])) {
  //code for captach verification
	if (($_POST["vercode"] != $_SESSION["vercode"]) OR $_SESSION["vercode"]=='') {
		echo "<script>alert('Code de verification incorrect');</script>" ;
	} else {
		$email=$_POST['email'];
		$mobile=$_POST['mobile'];
		$newpassword=md5($_POST['password']);
  		$sql ="SELECT EmailId FROM tblreaders WHERE EmailId=:email AND MobileNumber=:mobile";
		$query= $dbh -> prepare($sql);
		$query-> bindParam(':email', $email, PDO::PARAM_STR);
		$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
		$query-> execute();
		$result = $query -> fetch(PDO::FETCH_OBJ);
		
		if(!empty($result)) {
			$req="UPDATE tblreaders SET Password=:newpassword WHERE EmailId=:email AND MobileNumber=:mobile";
			$chngpwd1 = $dbh->prepare($req);
			$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
			$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
			$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
			$chngpwd1->execute();
			echo "<script>alert('Votre mot de passe a ete change');</script>";
		} else {
			echo "<script>alert('Email ou numero de portable inconnu');</script>"; 
		}
	}
}
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Recuperation de mot de passe </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <!-- link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' / -->
     
<script type="text/javascript">
function valid() {
	   let password = document.getElementById("password");
	   let checkPassword = document.getElementById("check-password");
	   
	   if (password.value === checkPassword.value) {
		   return true;
	   } else {
		   alert("Les mots de passe sont diff�rents.");
		   checkPassword.focus();
		   return false;
	   }
}
</script>

</head>
<body>
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
	<div class="container">
		<div class="row pad-botm">
			<div class="col-md-12">
				<h4 class="header-line">Recuperation de mot de passe</h4>
			</div>
		</div>
             
<!--LOGIN PANEL START-->           
		<div class="row">


          
			<div class="col-md-6 col-sm-6 col-xs-12 offset-md-3" >
				<div class="panel panel-info">
					<div class="panel-body">
						<form role="form" name="chngpwd" method="post" onSubmit="return valid();">
							<div class="form-group">
								<label>Email</label>
								<input class="form-control" type="email" name="email" required autocomplete="off" />
							</div>

							<div class="form-group">
							<label>Tel portable</label>
							<input class="form-control" type="text" name="mobile" required autocomplete="off" />
							</div>
							
							<div class="form-group">
							<label>Nouveau mot de passe</label>
							<input class="form-control" type="password" name="password" id="password" required autocomplete="off"  />
							</div>
							
							<div class="form-group">
							<label>Confirmer le mot de passe</label>
							<input class="form-control" type="password" name="check-password" id="check-password" required autocomplete="off"  />
							</div>
							
							 <div class="form-group">
							<label>Verification code : </label>
							<input type="text" class="form-control1"  name="vercode" maxlength="5" autocomplete="off" required  style="height:25px;" />&nbsp;<img src="captcha.php">
							</div> 
							
							 <button type="submit" name="change" class="btn btn-info">Envoyer</button> | <a href="index.php">Login</a>
						</form>
 					</div>
				</div>
			</div>
		</div>  
<!---LOGIN PABNEL END--> 
    </div>
</div>
     <!-- CONTENT-WRAPPER SECTION END-->
 <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>