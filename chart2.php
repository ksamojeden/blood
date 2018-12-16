<?php
// Definition of a class 'chart'
	class chart {
		public $height = 400;
		public $width = 900;
		public $x = array();
		public $y1 = array();
		public $y2 = array();
		public $yLabels = array();
		public $max_value_1 = 0;
		public $min_value_1 = 0;
		public $max_value_2 = 0;
		public $min_value_2 = 0;
		public $points_1 = "";
		public $points_2 = "";
		public $numberOfYLabels = 8;
		public $N = 0;
				
		public function readMeasurements() {
			$kwerenda = "SELECT `x`, `y1`, `y2` FROM `measurements`";
			$result = Zapytanie($kwerenda);
			if($result->num_rows > 0){
				$i = 0;
				while($row = $result->fetch_assoc()) {
					$this->x[$i] = $row['x'];
					$this->y1[$i] = $row['y1'];
					$this->y2[$i] = $row['y2'];
					$i = $i + 1;
				}
			}
			if (!isset($_SESSION['numberOfPoints'])) 
				$this->N = count($this->x);
			else
				$this->N = $_SESSION['numberOfPoints'];
		}

		public function calculateMaxMinValue() {
			$N = count($this->x);
			$i = $N - $this->N + 1;
			$this->max_value_1 = $this->y1[$i-1];
			$this->min_value_1 = $this->y1[$i-1];
			for ($i; $i < $N; $i++) {
				if ($this->y1[$i] > $this->max_value_1) 
					$this->max_value_1 = $this->y1[$i];
				if ($this->y1[$i] < $this->min_value_1) 
					$this->min_value_1 = $this->y1[$i];
			}
			$i = $N - $this->N + 1;
			$this->max_value_2 = $this->y2[$i-1];
			$this->min_value_2 = $this->y2[$i-1];
			for ($i; $i < $N; $i++) {
				if ($this->y2[$i] > $this->max_value_2) 
					$this->max_value_2 = $this->y2[$i];
				if ($this->y2[$i] < $this->min_value_2) 
					$this->min_value_2 = $this->y2[$i];
			}
		}
		
		public function calculatePoints() {
			$this->points_1 = "";
			$N = count($this->y1);
			
			if ($this->min_value_1 < $this->min_value_2) $min = $this->min_value_1;
			else $min = $this->min_value_2;
			
			if ($this->max_value_1 > $this->max_value_2) $max = $this->max_value_1;
			else $max = $this->max_value_2;
			
			$start = $N - $this->N;	// rzeczywisty start w zaleznosci od liczby wyswietlanych punktow
			
			for ($i = $start; $i < $N; $i++) {
				$yValue = $this->height - ($this->y1[$i] - $min) / ($max - $min) * $this->height;
				$xValue = ($this->x[$i] - $this->x[$start]) / ($this->x[$N-1] - $this->x[$start]) * $this->width;
				$this->points_1 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}
						
			$this->points_2 = "";
			for ($i = $start; $i < $N; $i++) {
				$yValue = $this->height - ($this->y2[$i] - $min) / ($max - $min) * $this->height;
				$xValue = ($this->x[$i] - $this->x[$start]) / ($this->x[$N-1] - $this->x[$start]) * $this->width;
				$this->points_2 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}
			
			/*
			for ($i=0; $i < $N; $i++) {
				$yValue = $this->height - ($this->y1[$i] - $this->min_value_1) / ($this->max_value_1 - $this->min_value_1) * $this->height;
				$xValue = $this->x[$i] / $this->x[$N-1] * $this->width;
				$this->points_1 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}
			
			$this->points_2 = "";
			for ($i=0; $i < $N; $i++) {
				$yValue = $this->height - ($this->y2[$i] - $this->min_value_2) / ($this->max_value_2 - $this->min_value_2) * $this->height;
				$xValue = $this->x[$i] / $this->x[$N-1] * $this->width;
				$this->points_2 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}
			*/
		}
		
		public function calcYAxisVal() {
			if ($this->min_value_1 < $this->min_value_2) $min = $this->min_value_1;
			else $min = $this->min_value_2;
			
			if ($this->max_value_1 > $this->max_value_2) $max = $this->max_value_1;
			else $max = $this->max_value_2;
			
			for ($i=0; $i < $this->numberOfYLabels; $i++) {
				$step = ($max - $min) / $this->numberOfYLabels;
				$this->yLabels[$i] = round($max - $step * $i,2);
			}
		}
	}
	
	$ch1 = new chart();
	$ch1->readMeasurements();
	$ch1->calculateMaxMinValue();
	$ch1->calculatePoints();
	$ch1->calcYAxisVal();
?>