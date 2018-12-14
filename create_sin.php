 <?php
	$BladIntegralnosciAplikacji = "Błąd integralności aplikacji";
	
	$inc = "nagl.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./funkcje.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>

<form action="create_sin.php" method="post">
  
  <div class="box1">
	  <div class="box2">
		  <h3>Wykres 1</h3>
		  A<br>
		  <input type="number" name="A1" placeholder="Amplituda" step="0.1" required><br><br>
		  <select name="wave1">
			<option value="sin">Sinus</option>
			<option value="cos">Cosinus</option>
		  </select>
	  </div>
	  <div class="box2">
		  <h3>Wykres 2</h3>
		  A<br>
		  <input type="number" name="A2" placeholder="Amplituda" step="0.1" required><br><br>
		  <select name="wave2">
			<option value="sin">Sinus</option>
			<option value="cos">Cosinus</option>
		  </select>
	  </div>
	  <div class="box2">
		  x0<br>
		  <input type="number" name="x0" placeholder="Wartość początkowa" step="0.1" required>
		  <br><br>
		  dt<br>
		  <input type="number" name="dt" placeholder="Skok" step="0.1" required >
		  <br><br>
		  N<br>
		  <input type="number" name="N" placeholder="Liczba punktów" required>  
	  </div>
	  
	  <br><br>
	  <input type="submit" value="Prześlij">
  </div>
  
  
  
</form>

<?php	
	if(!isset($_POST["x0"])) {
		$A1 = 0;
		$A2 = 0;
		$x0 = 0;
		$dt = 0;
		$N = 0;
		$w1 = "";
		$w2 = "";
		
	}
	else {
		$A1 = $_POST["A1"];
		$A2 = $_POST["A2"];
		$x0 = $_POST["x0"];
		$dt = $_POST["dt"];
		$N = $_POST["N"];
		$w1 = $_POST["wave1"];
		$w2 = $_POST["wave2"];
		
		$kwerenda = "SHOW TABLES LIKE 'measurements'";
		$result = Zapytanie($kwerenda);
		
		if($result->num_rows == 1) {
			// Table exists, clear it
			$kwerenda = "TRUNCATE TABLE measurements";
			$result = Zapytanie($kwerenda);
			
			for ($i = 0; $i < $N; $i++) {
				$x = $x0 + $dt * $i;
				$y1 = $A1 * round($w1($x), 2);
				$y2 = $A2 * round($w2($x), 2);
				
				$kwerenda = "INSERT INTO measurements (x, y1, y2) VALUES ($x, $y1, $y2)";
				$result = Zapytanie($kwerenda);
			}
		}
		else { 
			// Table does not exist
			
		}
		
		
		/*$si = $dx;
		for ($i = 0; $i < $N; $i++) {
			$x = $x0 + $dx * $i;
			$y = round(sin($x), 2);
			
			$kwerenda = "INSERT INTO measurements (x, y) VALUES ($x, $y)";
			$result = Zapytanie($kwerenda);
		}*/
	}
	
	
	$inc = "stopka.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>