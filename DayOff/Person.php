<?php
	class Person {
		public $id;
		public $name;
		public $Total;
		public $restToArrange;
		public $DayOff1;
		public $DayOff2 = 0;
		public $DayOff3 = 0;
		public $ondutys = array();
		// public $OnDuty1;
		// public $OnDuty2;
		// public $OnDuty3;
		// public $OnDuty4;
		public $Consecutive;
		public function __construct($id, $name, $Total, $DayOff1, $OnDuty1, $OnDuty2, $OnDuty3, $OnDuty4, $Consecutive) {
			$this->id = $id;
			$this->name = $name;
			$this->Total = $Total;
			$this->DayOff1 = $DayOff1;
			if ($OnDuty1 != 0) {
				$this->ondutys[] = $OnDuty1;
			}
			if ($OnDuty2 != 0) {
				$this->ondutys[] = $OnDuty2;
			}
			if ($OnDuty3 != 0) {
				$this->ondutys[] = $OnDuty3;
			}
			if ($OnDuty4 != 0) {
				$this->ondutys[] = $OnDuty4;
			}
			// $this->onduty1 = $OnDuty1;
			// $this->OnDuty2 = $OnDuty2;
			// $this->OnDuty3 = $OnDuty3;
			// $this->OnDuty4 = $OnDuty4;
			$this->Consecutive = $Consecutive;
			$this->restToArrange = $Total - 1;
		}
	}
?>