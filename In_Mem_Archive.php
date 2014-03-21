<?php
include('Obit.php');
include('School.php');
include('mysql_connect.php');

class In_Mem_Archive
{
    const EARLIEST_GRAD_YEAR = '1935';
    const QUERY = 
        "SELECT 
            firstname as fname, 
            middlename as mname, 
            lastname as lname, 
            designation, city, state, 
            DATE_FORMAT(deceaseddate, '%Y-%m-%e') as date_of_death, 
            dob as date_of_birth, 
            collegecode as school_id, 
            DATE_FORMAT(graddate, '%Y') as grad_year, 
            DATE_FORMAT(deceaseddate, '%Y') - DATE_FORMAT(dob, '%Y') - 
                (DATE_FORMAT(deceaseddate, '00-%m-%d') < 
                    DATE_FORMAT(dob, '00-%m-%d')) as age
         FROM inmemoriam
         WHERE deceaseddate > DATE_SUB(CURDATE(), INTERVAL 2 Year)
         ORDER BY lastname";

	public $obits;

	public function __construct()
	{
        $result = execute_query(self::QUERY);
        $this->obits = array();
        while ($row = mysql_fetch_assoc($result)) {
            $dead = new Obit($row);
            array_push($this->obits, $dead);
//            echo $dead;
        }
//        $this->printCollection(); // debug
	}

    public function getSize()
    {
        return count($this->obits);
    }

    // debug
    private function printCollection()
    {
        print_r($this->obits);
    }

    // debug
    public function printAllSchools()
    {
        echo "inside printAllSchools\n";
        echo "count of schools: " . School::getSchoolsCount() . "\n";
        $keys = School::getAllIds();

       foreach ($keys as $id) {
            echo School::getFullName($id) . "\n";
        }
    }

    public function getHeadline($query)
    {
        if (!array_key_exists('process-form', $query)) {
            return "In Memoriam: Two-year archive";
        }

        if (isset($query['school'])) {
            return School::getFullName($query['school']);
        } else if (isset($query['year'])) {
            return "Class of " . ($query['year']);
        } else if (isset($query['state'])) {
            return $this->getFullStateName($query['state']);
        }
    }

    private function getObitCountBySchool($schoolId)
    {
        $count = 0;
        foreach ($this->obits as $obit) {
            if ($obit->getSchoolId() == $schoolId) {
                $count++;
            }
        }

        return $count;
    }

    private function getObitCountByGradYear($year)
    {
        $count = 0;
        foreach ($this->obits as $obit) {
            if ($obit->getGradYear() == $year) {
                $count++;
            }
        }

        return $count;
    }

    private function getObitCountByState($state)
    {
        $count = 0;
        foreach ($this->obits as $obit) {
            if ($obit->getState() == $state) {
                $count++;
            }
        }
        
        return $count;
    }

    public function printDropdownByState()
    {
        $statesPostal = array(
            'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DC', 
            'DE', 'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA',
            'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI', 'MN',
            'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM',
            'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA', 'RI',
            'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA',
            'WV', 'WI', 'WY'
            );

        foreach ($statesPostal as $state) {
            $input = "";
            $input .= "<option value=\"" . $state . "\">";
            $input .= $state . " ";
            $input .= "(" . $this->getObitCountByState($state) . ")";
            $input .= "</option>" . "\n";
            echo $input;
        }
    }

    public function printDropdownBySchool()
    {
        $schoolIds = School::getAllIds();

        foreach ($schoolIds as $id) {
            $input = "";
            $input .= "<option value=\"" . $id . "\">";
            $input .= School::getAbbrev($id) . " ";
            $input .= "(" . $this->getObitCountBySchool($id) . ")";
            $input .= "</option>" . "\n";
            echo $input;
        }
    }

    public function printDropdownByYear()
    {
        $count = 0;
        $date = getdate();
        $thisYear = $date['year'];
        for ($i = $thisYear; $i > self::EARLIEST_GRAD_YEAR; $i--) {
            $input = "";
            $input .= "<option value=\"" . $i . "\">";
            $input .= $i . " ";
            $input .= "(" . $this->getObitCountByGradYear($i) . ")";
            $input .= "</option>" . "\n";
            echo $input;
        }
    }

    public function getObitsByState($state)
    {
        $archive = array();
        foreach ($this->obits as $obit) {
            if ($obit->getState() == $state) {
                array_push($archive, $obit);
            }
        }

        return $archive;
    }

    public function getObitsByYear($year)
    {
        $archive = array();
        foreach ($this->obits as $obit) {
            if ($obit->getGradYear() == $year) {
                array_push($archive, $obit);
            }
        }

        return $archive;
    }

    public function getObitsBySchool($schoolId) 
    {
        $archive = array();
        foreach ($this->obits as $obit) {
            if ($obit->getSchoolId() == $schoolId) {
                array_push($archive, $obit);
            }
        }
        
        return $archive;
    }

    /**
     * Determines whether to print--
     *      "graduates" or "graduate" or
     *      "students" or "student" or
     *      "graduates and students", etc.
     */
    private function getGradsAndStudents($schoolId)
    {
        // get all obit items from school
        $schoolObits = $this->getObitsBySchool($schoolId);
        $countDOs = 0;
        $countStudents = 0;

        foreach ($schoolObits as $obit) {
            $designation = $obit->getDesignation();
            // if we find a DO, increment the counter;
            if (!(strpos($designation, "DO") === false)) {
                $countDOs++;
            // otherwise, if we find a student, increment that counter
            } else if (!(strpos($designation, "OMS") === false)) {
                $countStudents++;
            }
        }
        
        // determine the language based on our counters
        $plurals = "";
        if ($countDOs == 0) {
            // then there must be at least 1 student
            $plurals .= ($countStudents > 1 ? "students" : "student");
            return $plurals;
        } else if ($countDOs == 1) {
            $plurals .= "graduate";
        } else if ($countDOs > 1) {
            $plurals .= "graduates";
        }

        if ($countStudents == 0) {
            return $plurals;
        } else if ($countStudents > 1) {
            $plurals .= " and students";
            return $plurals;
        } else if ($countStudents == 1) {
            $plurals .= " and student";
            return $plurals;
        } 
    }

    public function getBodyText($query)
    {
//        print_r($query); // debug
//        printf("\nschool is set: %s\n",
//            (isset($query['school']) ? "yes" : "no"));
//        printf("\nyear is set: %s\n",
//            (isset($query['year']) ? "yes" : "no"));
//        printf("\nstate is set: %s\n",
//            (isset($query['state']) ? "yes" : "no"));
        

        $bodyText = "";
        if (!array_key_exists('process-form', $query)) {
            $bodyText .= "Search for the names of osteopathic " .
                "physicians and osteopathic " .
                "medical students who have died within the past two years.";
            echo $bodyText;
            return;
        }

        if (isset($query['school'])) {
            $schoolId = $query['school'];
            $schoolArchive = $this->getObitsBySchool($schoolId);
            if (count($schoolArchive) > 0) {
                $bodyText .= "<em>The following ";
                $bodyText .= School::getAbbrev($schoolId) . " ";
                $bodyText .= $this->getGradsAndStudents($schoolId);
                $bodyText .= " died in the past two years.</em>";
                echo $bodyText;
                foreach ($schoolArchive as $obit) {
                    echo $obit;
                }
                return;
            } else {
                $bodyText .= "<em>No results for ";
                $bodyText .= School::getAbbrev($schoolId);
                $bodyText .= ".</em>";
                echo $bodyText;
                return;
            }
        }
        
        if (isset($query['year'])) {
            $gradYear = $query['year'];
            $yearArchive = $this->getObitsByYear($gradYear);
            if (count($yearArchive) > 0) {
                $bodyText .= "<em>The following member" . 
                    ((count($yearArchive) > 1 ? "s" : ""));
		   	    $bodyText .= " of the Class of " . $gradYear;
		   	    $bodyText .= count($yearArchive) > 1 ? " have" : " has";
		   	    $bodyText .= " died in the past two years.</em>";
                echo $bodyText;
                foreach ($yearArchive as $obit) {
                    echo $obit;
                }
                return;
            } else {
                $bodyText .= "<em>No results for the Class of " . $gradYear;
                $bodyText .= ".</em>";
                echo $bodyText;
                return;
            }
        }

        if (isset($query['state'])) {

            $state = $query['state'];
            $stateArchive = $this->getObitsByState($state);
            if (count($stateArchive) > 0) {
                $bodyText .= "<em>The following ";
                $bodyText .= $this->getFullStateName($state);
                $bodyText .= " resident" .
                    (count($stateArchive) > 1 ? "s" : "");
                $bodyText .= " died in the past two years.</em>";
                echo $bodyText;
                foreach ($stateArchive as $obit) {
                    echo $obit;
                }
                return;

            } else {
                $bodyText .= "<em>No results for "; 
                $bodyText .= $this->getFullStateName($state);
                $bodyText .= ".</em>";
                echo $bodyText;
                return;
            }
        }
    }
    
    private function getFullStateName($statePostal)
    {
        $states = array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming');

        return $states[$statePostal];
    }
}

?>
