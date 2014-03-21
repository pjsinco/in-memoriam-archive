<?php
class School
{
    private static $initialized = false;

    private static $schools = array (
      '196739' => array(
        'fullName' => "Alabama College of Osteopathic Medicine in Dothan",
        'abbrev' => "ACOM"),
      '118447' => array(
        'fullName' => "A.T. Still University-Kirksville (Mo.) College of Osteopathic Medicine",
        'abbrev' => "ATSU-KCOM"),
      '118439' => array(
        'fullName' => "A.T. Still University School of Osteopathic Medicine in Arizona in Mesa",
        'abbrev' => "ATSU-SOMA"),
      '118444' => array(
        'fullName' => "College of Osteopathic Physicians and Surgeons in Los Angeles",
        'abbrev' => "COPS"),
      '329224' => array(
        'fullName' => "Campbell University School of Osteopathic Medicine in Buies Creek, N.C.",
        'abbrev' => "CUSOM"),
      '118445' => array(
        'fullName' => "Des Moines (Iowa) University College of Osteopathic Medicine",
        'abbrev' => "DMU-COM"),
      '118454' => array(
        'fullName' => "Georgia Campus&mdash;Philadelphia College of Osteopathic Medicine in Suwanee",
        'abbrev' => "GA-PCOM"),
      '118446' => array(
        'fullName' => "Kansas City (Mo.) University of Medicine and Biosciences-College of Osteopathic Medicine",
        'abbrev' => "KCUMB-COM"),
      '118467' => array(
        'fullName' => "Lake Erie College of Osteopathic Medicine in Erie, Pa.",
        'abbrev' => "LECOM"),
      '118448' => array(
        'fullName' => "Lake Erie College of Osteopathic Medicine-Bradenton in Florida",
        'abbrev' => "LECOM-Bradenton"),
      '118440' => array(
        'fullName' => "Lincoln Memorial University-DeBusk College of Osteopathic Medicine in Harrogate, Tenn.",
        'abbrev' => "LMU-DCOM"),
      '118457' => array(
        'fullName' => "Michigan State University College of Osteopathic Medicine in East Lansing",
        'abbrev' => "MSUCOM"),
      '198802' => array(
        'fullName' => "Marian University College of Osteopathic Medicine in Indianapolis",
        'abbrev' => "MU-COM"),
      '118468' => array(
        'fullName' => "Midwestern University/Arizona College of Osteopathic Medicine in Glendale",
        'abbrev' => "MWU/AZCOM"),
      '118442' => array(
        'fullName' => "Midwestern University/Chicago College of Osteopathic Medicine in Downers Grove, Ill.",
        'abbrev' => "MWU/CCOM"),
      '118466' => array(
        'fullName' => "Nova Southeastern University College of Osteopathic Medicine in Fort Lauderdale, Fla.",
        'abbrev' => "NSU-COM"),
      '118463' => array(
        'fullName' => "New York Institute of Technology College of Osteopathic Medicine in Old Westbury",
        'abbrev' => "NYITCOM"),
      '118460' => array(
        'fullName' => "Oklahoma State University Center for Health Sciences College of Osteopathic Medicine in Tulsa",
        'abbrev' => "OSU-COM"),
      '118461' => array(
        'fullName' => "Ohio University Heritage College of Osteopathic Medicine in Athens",
        'abbrev' => "OU-HCOM"),
      '118453' => array(
        'fullName' => "Philadelphia College of Osteopathic Medicine",
        'abbrev' => "PCOM"),
      '182634' => array(
        'fullName' => "Pacific Northwest University of Health Sciences, College of Osteopathic Medicine in Yakima, Wash.",
        'abbrev' => "PNWU-COM"),
      '182613' => array(
        'fullName' => "Rocky Vista University College of Osteopathic Medicine in Parker, Colo.",
        'abbrev' => "RVUCOM"),
      '118441' => array(
        'fullName' => "Touro College of Osteopathic Medicine in New York City",
        'abbrev' => "TouroCOM"),
      '118469' => array(
        'fullName' => "Touro University California, College of Osteopathic Medicine in Vallejo",
        'abbrev' => "TUCOM"),
      '118449' => array(
        'fullName' => "Touro University Nevada College of Osteopathic Medicine in Henderson",
        'abbrev' => "TUNCOM"),
      '118462' => array(
        'fullName' => "University of Medicine and Dentistry of New Jersey-School of Osteopathic Medicine in Stratford",
        'abbrev' => "UMDNJ-SOM"),
      '118465' => array(
        'fullName' => "University of New England College of Osteopathic Medicine in Biddeford, Maine",
        'abbrev' => "UNECOM"),
      '118458' => array(
        'fullName' => "University of North Texas Health Science Center Texas College of Osteopathic Medicine in Fort Worth",
        'abbrev' => "UNTHSC/TCOM"),
      '118470' => array(
        'fullName' => "University of Pikeville-Kentucky College of Osteopathic of Osteopathic Medicine",
        'abbrev' => "UP-KYCOM"),
      '198805' => array(
        'fullName' => "Edward Via College of Osteopathic Medicine-Carolinas Campus in Spartanburg, S.C.",
        'abbrev' => "VCOM-Carolinas"),
      '155767' => array(
        'fullName' => "Edward Via Virginia College of Osteopathic Medicine&mdash;Virginia Campus in Blacksburg",
        'abbrev' => "VCOM-Virginia"),
      '188393' => array(
        'fullName' => "William Carey University College of Osteopathic Medicine in Hattiesburg, Miss.",
        'abbrev' => "WCUCOM"),
      '118464' => array(
        'fullName' => "Western University of Health Sciences College of Osteopathic Medicine of the Pacific in Pomona, Calif.",
        'abbrev' => "WesternU/COMP"),
      '118459' => array(
        'fullName' => "West Virginia School of Osteopathic Medicine in Lewisburg",
        'abbrev' => "WVSOM")
    );

    private static function initialize()
    {
        if (self::$initialized) {
            return;
        } else {
            self::$initialized = true;
        }
    }

    public function getFullName($schoolId)
    {
        self::initialize();

        return self::$schools[$schoolId]['fullName'];
    }

    public function getAbbrev($schoolId)
    {
        self::initialize();

        return self::$schools[$schoolId]['abbrev'];
    }

    // debug
    // returns # of schools
    public function getSchoolsCount()
    {
        self::initialize();

        return count(self::$schools);
    }

    // debug
    // returns an array of all school IDs
    public function getAllIds()
    {
        self::initialize();

        return array_keys(self::$schools);
    }
}
?>
