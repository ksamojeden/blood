  <?php
	session_start();	
	$BladIntegralnosciAplikacji = "Błąd integralności aplikacji";
	
	$inc = "nagl.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./funkcje.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");

	$inc = "./chart.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>	
	
	<h1>Przykład prezentacji danych za pomocą grfiki SVG</h1>
	<div class="container">
		<div class="chart">
			<div class="yearLabel"><?php echo $ch1->year;?></div>
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
					if (count($ch1->x) < 3) {
						echo "<div class=\"xLabelLeft\">" . $ch1->x[count($ch1->x) - 2] . "</div><br>";
						echo "<div class=\"xLabelRight\">" . $ch1->x[count($ch1->x) - 1] . "</div><br>";
					}
					else {
						echo "<div class=\"xLabelLeft\">" . $ch1->x[0] . "</div><br>";
						for($i=1; $i < count($ch1->x) - 1; $i++) 
							echo "<div class=\"xLabel\">" . $ch1->x[$i] . "</div><br>";
						echo "<div class=\"xLabelRight\">" . $ch1->x[count($ch1->x) - 1] . "</div><br>";
					}
				?>				
			</div>
			</svg>
		</div>

	</div>
	
	
	
<?php
	$inc = "stopka.php";
	if(file_exists($inc)) include($inc);
	else header("Location: app_error.php?tx_err=$BladIntegralnosciAplikacji&gdzie=$inc");
?>