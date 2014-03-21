<?php
 /**
 * following some advice found here:
 * http://stackoverflow.com/questions/468642/
 *      is-it-possible-to-create-static-classes-in-php-like-in-c
 */
class AP_Style
{
//    private static $instance;
    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized) {
            return;
        } else {
            self::$initialized = true;
        }
    }

    /**
     * takes '2012-03-5' formatted string and returns 
     * how it should be displayed per AP
     */
    public static function formatDate($date)
	{
        self::initialize();

        $formattedDate = '';

        $dateArr = explode('-', $date);
        $year = $dateArr[0];
        $month = $dateArr[1];
        $day = $dateArr[2];

        $formattedDate .= self::formatMonth($month) . ' ';
        $formattedDate .= $day;
//        $formattedDate .= ($day < 10) ? substr($day, 1) : $day;
        $formattedDate .= self::formatYear($year);

        return $formattedDate;
	}

    public static function formatYear($year)
    {
        self::initialize();

        $formattedYear = '';
		$date = getdate();
		$curr_year = $date['year'];
		if ($curr_year != $year) {
			$formattedYear .= ', ' . $year;
		}
		return $formattedYear;
    }

	//change month to AP style
	public function formatMonth($month)
	{
        self::initialize();

		switch($month) {
		case '01':
			return 'Jan.';
			break;
		case '02':
			return 'Feb.';
			break;
		case '03':
			return 'March';
			break;
		case '04':
			return 'April';
			break;
		case '05':
			return 'May';
			break;
		case '06':
			return 'June';
			break;
		case '07':
			return 'July';
			break;
		case '08':
			return 'Aug.';
			break;
		case '09':
			return 'Sept.';
			break;
		case '10':
			return 'Oct.';
			break;
		case '11':
			return 'Nov.';
			break;
		case '12':
			return 'Dec.';
			break;
		}
	}

	public function formatState($abbrev)
	{
      self::initialize();

      switch($abbrev) {
        case 'AK':
          return 'Alaska';
          break;
        case 'AL':
          return 'Ala.';
          break;
        case 'AZ':
          return 'Ariz.';
          break;
        case 'AR':
          return 'Ark.';
          break;
        case 'CA':
          return 'Calif.';
          break;
        case 'CO':
          return 'Colo.';
          break;
        case 'CT':
          return 'Conn.';
          break;
        case 'DE':
          return 'Del.';
          break;
        case 'FL':
          return 'Fla.';
          break;
        case 'GA':
          return 'Ga.';
          break;
        case 'HI':
          return 'Hawaii';
          break;
        case 'IA':
          return 'Iowa';
          break;
        case 'ID':
          return 'Idaho';
          break;
        case 'IL':
          return 'Ill.';
          break;
        case 'IN':
          return 'Ind.';
          break;
        case 'KS':
          return 'Kan.';
          break;
        case 'KY':
          return 'Ky.';
          break;
        case 'LA':
          return 'La.';
          break;
        case 'MD':
          return 'Md.';
          break;
        case 'ME':
          return 'Maine';
          break;
        case 'MA':
          return 'Mass.';
          break;
        case 'MI':
          return 'Mich.';
          break;
        case 'MN':
          return 'Minn.';
          break;
        case 'MS':
          return 'Miss.';
          break;
        case 'MO':
          return 'Mo.';
          break;
        case 'MT':
          return 'Mont.';
          break;
        case 'NE':
          return 'Neb.';
          break;
        case 'NV':
          return 'Nev.';
          break;
        case 'NH':
          return 'N.H.';
          break;
        case 'NJ':
          return 'N.J.';
          break;
        case 'NM':
          return 'N.M.';
          break;
        case 'NY':
          return 'N.Y.';
          break;
        case 'NC':
          return 'N.C.';
          break;
        case 'ND':
          return 'N.D';
          break;
        case 'OH':
          return 'Ohio';
          break;
        case 'OK':
          return 'Okla.';
          break;
        case 'OR':
          return 'Ore.';
          break;
        case 'PA':
          return 'Pa.';
          break;
        case 'RI':
          return 'R.I.';
          break;
        case 'SC':
          return 'S.C.';
          break;
        case 'SD':
          return 'S.D.';
          break;
        case 'TN':
          return 'Tenn.';
          break;
        case 'TX':
          return 'Texas';
          break;
        case 'UT':
          return 'Utah';
          break;
        case 'VT':
          return 'Vt.';
          break;
        case 'VA':
          return 'Va.';
          break;
        case 'WA':
          return 'Wash.';
          break;
        case 'WV':
          return 'W.Va.';
          break;
        case 'WI':
          return 'Wis.';
          break;
        case 'WY':
          return 'Wyo.';
          break;
      }
    }

	// check to see if city can stand on its own
	// if it can, remove state and commas
    // takes:
    //      'Salt Lake City', 'UT'
    //      'Minneapolis', 'MN'
    //      'Grand Rapids', 'MI'
    // returns:
    //      Salt Lake City
    //      Minneapolis
    //      Grand Rapids, Mich.
	function formatDateline($city, $state)
	{
        self::initialize();

        $formattedDateline = '';
		if (
			($city=='Atlanta' && $state=='GA')
			|| ($city=='Baltimore' && $state=='MD')
			|| ($city=='Boston' && $state=='MA') 
			|| ($city=='Chicago' && $state=='IL')
			|| ($city=='Cincinnati' && $state=='OH')
			|| ($city=='Cleveland' && $state=='OH')
			|| ($city=='Dallas' && $state=='TX')
			|| ($city=='Denver' && $state=='CO')
			|| ($city=='Detroit' && $state=='MI')
			|| ($city=='Honolulu' && $state=='HI')
			|| ($city=='Houston' && $state=='TX')
			|| ($city=='Indianapolis' && $state=='IN')
			|| ($city=='Las Vegas' && $state=='NV')
			|| ($city=='Los Angeles' && $state=='CA')
			|| ($city=='Miami' && $state=='FL')
			|| ($city=='Milwaukee' && $state=='WI')
			|| ($city=='Minneapolis' && $state=='MN')
			|| ($city=='New Orleans' && $state=='LA')
			|| ($city=='New York' && $state=='NY')
			|| ($city=='New York City' && $state=='NY')
			|| ($city=='Oklahoma City' && $state=='OK')
			|| ($city=='Philadelphia' && $state=='PA')
			|| ($city=='Phoenix' && $state=='AZ')
			|| ($city=='Pittsburgh' && $state=='PA')
			|| ($city=='Salt Lake City' && $state=='UT')
			|| ($city=='San Antonio' && $state=='TX')
			|| ($city=='San Diego' && $state=='CA')
			|| ($city=='San Francisco' && $state=='CA')
			|| ($city=='Seattle' && $state=='WA')
			|| ($city=='St. Louis' && $state=='MO')
			|| ($city=='St Louis' && $state=='MO')
			|| ($city=='Saint Louis' && $state=='MO')
			|| ($city=='Washington' && $state=='DC')
			) {
            $formattedDateline .= $city;
		} else {
            $formattedDateline .= $city . ', ' . self::formatState($state) . ',';
		}
		return $formattedDateline;
	}

}

?>
