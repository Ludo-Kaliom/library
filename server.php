<?php
// Array with names
$reponse = 42;

// get the q parameter from URL
$q = $_REQUEST["q"];

if ($q !== "") {
	$q = intval($q);
	
	if ($q < $reponse) {
		$hint = "C'est plus !";
	} elseif ($q > $reponse) {
		$hint = "C'est moins !";
	} else {
		$hint = "C'est la bonne reponse !!";
	}
}

echo $hint;
?>
