<?php
	session_start();	
	$BladIntegralnosciAplikacji = "Błąd integralności aplikacji";
	
	$inc = "nagl.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./funkcje.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
	
	$kwerenda = "SELECT x,y1,y2 FROM measurements INTO OUTFILE '/tmp/meas.csv'
		FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
	$result = Zapytanie($kwerenda);
	
	if($result) echo "Pomyślnie.";
	else echo "Nie powiodło się.";
		
	$inc = "stopka.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>