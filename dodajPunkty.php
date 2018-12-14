<?php
	$w1 = $_POST['blueWave'];
	$w2 = $_POST['redWave'];
	
	$kwerenda = "SELECT x FROM measurements ORDER BY id DESC LIMIT 2";
	$result = Zapytanie($kwerenda);
	if($result->num_rows >= 2) {
		$x2 = $result->fetch_assoc()['x'];
		$x1 = $result->fetch_assoc()['x'];
		echo $x2 . "  " . $x1;
		$x = $x2 + ($x2 - $x1);
	}
	elseif ($result->num_rows = 1) $x = 0.5;
	else $x = 0;
	
	$kwerenda = "INSERT INTO measurements (x, y1, y2) VALUES ($x, $w1, $w2)";
	$result = Zapytanie($kwerenda);
?>