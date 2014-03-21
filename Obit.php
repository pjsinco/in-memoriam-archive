<?php 
//	include('School.php');
	include('AP_Style.php');

	class Obit
	{
        private $firstName; 
		private $middleName;
		private $lastName;
		private $designation;
		private $schoolId;
		private $gradYear;
		private $city;
		private $state;
		private $dod;
		private $dob;
		private $age;

  		function __construct($row)
  		{
			$this->firstName = $row['fname'];
			$this->middleName = $row['mname'];
			$this->lastName = $row['lname'];
			$this->designation = $row['designation'];
			$this->schoolId = $row['school_id'];
			$this->gradYear = $row['grad_year'];
			$this->city = $row['city'];
			$this->state = $row['state'];
			$this->dod = $row['date_of_death'];
			$this->dob = $row['date_of_birth'];
			$this->age = $row['age'];

//            $this->printBirthDate(); // debug
//            $this->printDeathDate(); // debug
//            $this->printDateline(); // debug
		}

		public function getName()
		{
			return $this->firstname . ' ' . $this->middlename . ' ' . 
                $this->lastname;
		}

        public function getGradYear()
        {
            return $this->gradYear;
        }

        public function getDesignation()
        {
            return $this->designation;
        }

        public function getSchoolId()
        {
            return $this->schoolId;
        }

        public function getState()
        {
            return $this->state;
        }

        // print...() functions are for debugging
        public function printBirthDate()
        {
              $fDate = AP_Style::formatDate($this->dob);
              echo $fDate . "\n";
        }

        public function printDeathDate()
        {
            $fDate = AP_Style::formatDate($this->dod);
            echo $fDate . "\n";
        }

        public function printDateline()
        {
            $dateline = AP_Style::formatDateline($this->city, $this->state);
            echo $dateline . "\n";
        }

        public function __toString()
        {
            $obit = '';
            $obit .= '<p><strong>';
            $obit .= $this->firstName . ' ' . $this->middleName .  ' ' . 
                $this->lastName;
            $obit .= ', ' . $this->designation . ',</strong> '. $this->age;
            $obit .= ' ('. School::getAbbrev($this->schoolId) . ' ' ;
            $obit .= $this->gradYear . '), of ';
            $obit .= AP_Style::formatDateline($this->city, $this->state) ;
            $obit .= ' died ' . AP_Style::formatDate($this->dod) . '.</p>';

            return $obit;
        }


	}
