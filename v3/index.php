<?php
	session_start();
	if(!isset($_SESSION['offset']))
		$_SESSION['offset'] = 0;
	if(!isset($_SESSION['noOfDays']))
		$_SESSION['noOfDays'] = 7;
	$BladIntegralnosciAplikacji = "Błąd integralności aplikacji";
	
	if (isset($_POST['arrow'])) {
		$_SESSION['offset'] += $_POST['arrow'];
		unset($_POST['arrow']);
	}
	
	$inc = "nagl.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./funkcje.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./chart2.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
	
?>	

	<h1>Przykład prezentacji danych za pomocą grfiki SVG</h1>
	<div class="container">
		<form id="myForm" action="./index.php" method="post">
			<select name="noOfDays" onchange="myFunction()">
				<option value="7">--</option>
				<option value="7">Tydzień</option>
				<option value="14">Dwa tygodnie</option>
			</select>
		</form>
		<svg height="<?php echo $chart1->height;?>" width="<?php echo $chart1->width;?>">
						
			<!-- year -->
			<text x="<?php echo $chart1->yLabelWidth + $chart1->chartWidth - 75; ?>" y="45" class="yearLabel"><?php echo $chart1->year; ?></text>
			<!-- x labels -->
			<?php 
				for ($i = 0; $i < $chart1->noOfDays; $i++) {
					$x = $chart1->xLabelPos[$i];
					$y = $chart1->yearLabelHeight + 25;
					$y2 = $y + 20;
					$ind = $i+$chart1->startPoint;
					echo '<text x="' . $x .'" y="' . $y .'">' . $chart1->xLabels[$ind][0] . '<tspan x="' . $x .'" y="' . $y2 . '">' . $chart1->xLabels[$ind][1] . '</tspan></text>';
				}
			?>
			
			<!-- y labels -->
			<?php 
				for ($i = 0; $i < $chart1->noOfLines; $i++) {
					echo '<text x="0" y="' . $chart1->yLabelPos[$i] . '" ">' . $chart1->yLabels[$i] . '</text>';
				}
			?>
			<!-- systolic and diastolic pressure lines -->
			<polyline points="<?php echo $chart1->points1;?>" style="stroke: rgba(65, 131, 215, .6);"/>
			<polyline points="<?php echo $chart1->points2;?>" style="stroke: rgba(167, 14, 37, .6);"/>
			<!-- horizontal grid lines-->
			<?php 
				for ($i = 0; $i < $chart1->noOfLines; $i++) {
					$x2 = $chart1->yLabelWidth + $chart1->chartWidth;
					echo '<line x1="0" y1="' . $chart1->gridLinesPos[$i] . '" x2="' . $x2 . '" y2="' . $chart1->gridLinesPos[$i] . '" style="stroke:rgb(219, 220, 221);stroke-width:1" />';
				}
				
			?>	
			
		</svg>
		<div class="buttonBox">
		<form id="myForm2" action="./index.php" method="post">
			<button name="arrow" type="submit" value="-1">&#x2190;</button>
			<button name="arrow" type="submit" value="1">&#x2192;</button>
		</form>
		</div>

	</div>
	

	
	
<?php
	$inc = "stopka.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>