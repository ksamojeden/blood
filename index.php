 <?php
	session_start();	
	$BladIntegralnosciAplikacji = "Błąd integralności aplikacji";
	
	$inc = "nagl.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./funkcje.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
	
	if(isset($_POST['myRange'])) $_SESSION['numberOfPoints'] = $_POST['myRange'];
	
	if(isset($_POST['blueWave'])) {
		$inc = "dodajPunkty.php";
		if(file_exists($inc)) include($inc);
		else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
	}

	$inc = "./chart.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>	
	
	<h1>Przykład prezentacji danych za pomocą grfiki SVG</h1>
	<div class="container">
		<div class="chart">
			<svg height="<?php echo $ch1->height;?>" width="<?php echo $ch1->width;?>">
			<polyline points="<?php echo $ch1->points_1;?>" style="stroke: rgba(65, 131, 215, .6);"/>
			<polyline points="<?php echo $ch1->points_2;?>" style="stroke: rgba(167, 14, 37, .6);"/>
			<div class="yLabels">	
			<?php
				for($i=0; $i < $ch1->numberOfYLabels; $i++) 
					echo "<div class=\"yLabel\">" . $ch1->yLabels[$i] . "</div><br>";
			?>
			</div>
			<div class="xLabels">
				<?php
					if ($ch1->N < 3) {
						echo "<div class=\"xLabelLeft\">" . $ch1->x[count($ch1->x) - 2] . "</div><br>";
						echo "<div class=\"xLabelRight\">" . $ch1->x[count($ch1->x) - 1] . "</div><br>";
					}
					else {
						echo "<div class=\"xLabelLeft\">" . $ch1->x[count($ch1->x) - $ch1->N] . "</div><br>";
						for($i=count($ch1->x) - $ch1->N + 1; $i < count($ch1->x) - 1; $i++) 
							echo "<div class=\"xLabel\">" . $ch1->x[$i] . "</div><br>";
						echo "<div class=\"xLabelRight\">" . $ch1->x[count($ch1->x) - 1] . "</div><br>";
					}
				?>				
			</div>
			</svg>
		</div>
		<form action="index.php" method="post">
			<p>Wybierz liczbę ostatnich punktów, które mają zostać wyświetlone: <b><span id="numberOfPoints"></b></p>
			<div class="slidercontainer">
			  <input type="range" min="2" max="<?php echo count($ch1->x);?>" value="<?php echo $ch1->N;?>" step="1" name="myRange" class="slider" id="myRange">
			  <script src="slider.js"></script>
			  <br><br>
			  <input type="submit" value="Wyświetl">
			</div>
		</form>
		<form action="index.php" method="post">
			<p>Jeśli chcesz dodać punkty do wykresu, podaj wartość ich rzędnych:</p>
			Wykres niebieski: <input type="number" min="-1000000" max="1000000" step="0.1" name="blueWave" required><br>
			Wykres czerwony: <input type="number" min="-1000000" max="1000000" step="0.1" name="redWave" required><br><br>
			<input type="submit" value="Dodaj">
		</form>
	</div>
	
	
	
<?php
	$inc = "stopka.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>