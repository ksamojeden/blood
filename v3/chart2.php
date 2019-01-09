 <?php
	class chart {
		public $height = 540;
		public $width = 790;
		public $chartHeight = 400;
		public $chartWidth = 700;
		public $xLabelHeight = 60;
		public $yLabelWidth = 50;
		public $yearLabelHeight = 50;
		public $xLabels = array();	// days of week
		public $y1 = array();	// systolic pressure
		public $y2 = array();	// diastolic pressure
		public $maxVal1 = 0;	// max systolic pressure
		public $minVal1 = 0;	// min systolic pressure
		public $maxVal2 = 0;	// max diastolic pressure
		public $minVal2 = 0;	// min diastolic pressure
		public $minVal = 0;		// min pressure
		public $maxVal = 0;		// max pressure
		public $points1 = "";	// systolic pressure points' postitions
		public $points2 = "";	// diastolic pressure points' postitions
		public $year;
		public $years = array();
		public $gridLinesPos = array(); 	// postitions of horizontal grid lines
		public $noOfLines = 0;				// number of horizontal grid lines
		public $yLabelPos = array();		// positions of y labels
		public $yLabels = array();			// values of y labels
		public $xLabelPos = array();		// positions of y labels
		public $noOfDays;
		public $startPoint;
		public $endPoint;
		
		function __construct() {
			if(isset($_POST['noOfDays'])) {
				$_SESSION['noOfDays'] = $_POST['noOfDays'];
				$_SESSION['offset'] = 0;
			}
			$this->noOfDays = $_SESSION['noOfDays'];
		}
		
		
	
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
					$this->xLabels[$i][0] = $date;
					$this->xLabels[$i][1] = $nameOfTheDay;
					$this->y1[$i] = $row['systolic'];
					$this->y2[$i] = $row['diastolic'];
					$this->years[$i] = $row['year'];
					$i = $i + 1;
				}
				$this->startPoint = count($this->y1) - $this->noOfDays + $_SESSION['offset'];
				if ($this->startPoint < 0) {
					$this->startPoint = 0;
					$_SESSION['offset'] = $_SESSION['offset'] + 1;
				}
				if ($this->startPoint > (count($this->y1) - $this->noOfDays)) {
					$this->startPoint = count($this->y1) - $this->noOfDays;
					$_SESSION['offset'] = $_SESSION['offset'] - 1;
				}
				$this->endPoint = $this->startPoint + $this->noOfDays;
				$this->year = $this->years[$this->endPoint-1];
			}
		}
		
		public function calculateMaxMinValue() {
			$N = $this->startPoint + $this->noOfDays;	// end point
			// calculate min and max systolic pressure
			$this->maxVal1 = $this->y1[$this->startPoint];
			$this->minVal1 = $this->y1[$this->startPoint];
			for ($i=$this->startPoint; $i < $N; $i++) {
				if ($this->y1[$i] > $this->maxVal1) 
					$this->maxVal1 = $this->y1[$i];
				if ($this->y1[$i] < $this->minVal1) 
					$this->minVal1 = $this->y1[$i];
			}
			// calculate min and max diastolic pressure
			$this->maxVal2 = $this->y2[$this->startPoint];
			$this->minVal2 = $this->y2[$this->startPoint];
			for ($i=$this->startPoint; $i < $N; $i++) {
				if ($this->y2[$i] > $this->maxVal2) 
					$this->maxVal2 = $this->y2[$i];
				if ($this->y2[$i] < $this->minVal2) 
					$this->minVal2 = $this->y2[$i];
			}
			
			// calculate max and min values on chart
			if ($this->minVal1 < $this->minVal2) $this->minVal = $this->minVal1;
			else $this->minVal = $this->minVal2;
			
			if ($this->maxVal1 > $this->maxVal2) $this->maxVal = $this->maxVal1;
			else $this->maxVal = $this->maxVal2;
			
			// round
			$this->minVal = floor($this->minVal/10) * 10;
			$this->maxVal = ceil($this->maxVal/10) * 10;
		}
		
		public function calculatePoints() {
			$this->points_1 = "";
			$N = count($this->y1);	// number of points
			$xPos = 50;
			$yPos = 110;
			
			for ($i = $this->startPoint; $i < $this->endPoint; $i++) {
				$yValue = $this->chartHeight - ($this->y1[$i] - $this->minVal) / ($this->maxVal - $this->minVal) * $this->chartHeight + $yPos;
				$xValue = ($i-$this->startPoint) / ($this->noOfDays-1) * $this->chartWidth + $xPos;
				$this->points1 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}
					
			$this->points_2 = "";
			for ($i = $this->startPoint; $i < $this->endPoint; $i++) {
				$yValue = $this->chartHeight - ($this->y2[$i] - $this->minVal) / ($this->maxVal - $this->minVal) * $this->chartHeight + $yPos;
				$xValue = ($i-$this->startPoint) / ($this->noOfDays-1) * $this->chartWidth + $xPos;
				$this->points2 .=  round($xValue,2) . "," . round($yValue,2) . " ";
			}		
		}
		
		public function calcGridLinesPos() {
			$this->noOfLines = ($this->maxVal - $this->minVal) / 10 + 1;
			$xPos = 50;
			$yPos = 110;
			$dy = $this->chartHeight / ($this->noOfLines - 1);
			for ($i=0; $i<$this->noOfLines; $i++) {
				$this->gridLinesPos[$i] = $i * $dy + $yPos;
			}
		}
		
		public function calcYLabelPos() {
			for ($i=0; $i<$this->noOfLines; $i++) {
				$this->yLabelPos[$i] = $this->gridLinesPos[$i] + 18;
			}
		}
		
		public function calcYAxisVal() {		
			for ($i=0; $i < $this->noOfLines; $i++) {
				$step = ($this->maxVal - $this->minVal) / ($this->noOfLines - 1);
				$this->yLabels[$i] = round($this->maxVal - $step * $i,2);
			}
		}
		
		public function calcXLabelPos() {
			$xPos = 50;
			$this->xLabelPos[$this->startPoint] = $xPos;
			$this->xLabelPos[$this->noOfDays-1] = $this->chartWidth - 45 + $xPos;			
			for ($i=0; $i<$this->noOfDays-1; $i++) {
				$this->xLabelPos[$i] = $i * $this->chartWidth / ($this->noOfDays-1) + $xPos - 15;
			}
		}
		
	}
	
	$chart1 = new chart();
	$chart1->readMeasurements();
	$chart1->calculateMaxMinValue();
	$chart1->calculatePoints();
	$chart1->calcGridLinesPos();
	$chart1->calcYLabelPos();
	$chart1->calcYAxisVal();
	$chart1->calcXLabelPos();
 ?>