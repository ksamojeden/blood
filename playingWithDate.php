 <?php
	session_start();	
	$BladIntegralnosciAplikacji = "Błąd integralności aplikacji";
	
	$inc = "nagl.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./funkcje.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
	
	
	date_default_timezone_set('UTC');
	
	$kwerenda = "SELECT * FROM `blood_pressure`";
	$result = Zapytanie($kwerenda);
	while ($row = $result->fetch_assoc()) 
	{
		$day = $row['day'];
		$month = $row['month'];
		$year = $row['year'];
		$date = $day . "-" . $month . "-" . $year; 
		$systolic = $row['systolic'];
		$diastolic = $row['diastolic'];
		$hr = $row['hr'];
		$time = $row['time'];
		if($time == 0)
			$partOfADay = "at the morning";
		else 
			$partOfADay = "at the evening";
		
		echo $date . ", " . date("l", mktime(0, 0, 0, $month, $day, $year)) . " " . $partOfADay . "<br>";
		echo $systolic . "/" . $diastolic . ", heart rate: " . $hr . "<br>";
	}
	
	
	$inc = "stopka.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>