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
		public $year;
				
		public function readMeasurements() {
			$kwerenda = "SELECT `systolic`, `diastolic`, `day`, `month`, `year`, `time` FROM `blood_pressure`";
			$result = Zapytanie($kwerenda);
			if($result->num_rows > 0){
				$i = 0;
				while($row = $result->fetch_assoc()) {
					
					$day = $row['day'];
					$month = $row['month'];
					$year = $row['year'];
					$date = $day . "-" . $month; 
					$time = $row['time'];
					$this->year = $year;
					if($time == 0)
						$partOfADay = "at the morning";
					else 
						$partOfADay = "at the evening";
					$dayOfWeek = date("N", mktime(0, 0, 0, $month, $day, $year));
					switch ($dayOfWeek) {
						case 1:
							$nameOfTheDay = "Pon.";
							break;
						case 2:
							$nameOfTheDay = "Wt.";
							break;
						case 3:
							$nameOfTheDay = "Śr.";
							break;
						case 4:
							$nameOfTheDay = "Czw.";
							break;
						case 5:
							$nameOfTheDay = "Pt.";
							break;
						case 6:
							$nameOfTheDay = "So.";
							break;
						case 7:
							$nameOfTheDay = "Nd.";
							break;
					}
					$this->x[$i] = $date . "<br>" . $nameOfTheDay;
					$this->y1[$i] = $row['systolic'];
					$this->y2[$i] = $row['diastolic'];
					$i = $i + 1;
				}
			}
		}

		public function calculateMaxMinValue() {
			$N = count($this->x);
			$i = 1;
			$this->max_value_1 = $this->y1[$i-1];
			$this->min_value_1 = $this->y1[$i-1];
			for ($i; $i < $N; $i++) {
				if ($this->y1[$i] > $this->max_value_1) 
					$this->max_value_1 = $this->y1[$i];
				if ($this->y1[$i] < $this->min_value_1) 
					$this->min_value_1 = $this->y1[$i];
			}
			$i = 1;
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
			
			$min = floor($min/10) * 10;
			$max = ceil($max/10) * 10; 
			
			$start = 0;	// rzeczywisty start w zaleznosci od liczby wyswietlanych punktow
			
			for ($i = $start; $i < $N; $i++) {
				$yValue = $this->height - ($this->y1[$i] - $min) / ($max - $min) * $this->height;
				$xValue = ($i - $start) / ($N-1 - $start) * $this->width;
				$this->points_1 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}
					
			$this->points_2 = "";
			for ($i = $start; $i < $N; $i++) {
				$yValue = $this->height - ($this->y2[$i] - $min) / ($max - $min) * $this->height;
				$xValue = ($i - $start) / ($N-1 - $start) * $this->width;
				$this->points_2 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}		
		}
		
		public function calcYAxisVal() {
			if ($this->min_value_1 < $this->min_value_2) $min = $this->min_value_1;
			else $min = $this->min_value_2;
			
			if ($this->max_value_1 > $this->max_value_2) $max = $this->max_value_1;
			else $max = $this->max_value_2;
			
			$min = floor($min/10) * 10;
			$max = ceil($max/10) * 10;
			$this->numberOfYLabels = ($max-$min)/10;
			
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