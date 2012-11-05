<?php

abstract class Application_Model_Functions
{
	public $userid;

	public static function getUserAgent()
	{
		if (isset($_SERVER['HTTP_USER_AGENT'])){
			if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) {
				// Chrome user agent string contains both 'Chrome' and 'Safari'
				if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
					return 'chrome';
				} else {
					return 'safari';
				}
			} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
				return 'opera';
			} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
				return 'firefox';
			} else {
				return 'default';
			}
		} else {
			return 'default';
		}
	}

    // tries to get the id from the url
    public static function getId()
    {
        $userId = '';
        $front = Zend_Controller_Front::getInstance();
        $array = $front->getRequest()->getParams();
        $userId = $front->getRequest()->getParam('id');

        if(!isset($userId)){
            array_filter($array, function($value) {
                if(is_numeric($value)){
                    $userId = $value;
                }
            });
        }

        if($userId == null ){
                $userId = 2964339;
            if(LOGGEDIN){
                $userId = USERID;
            }
        }
        return $userId;
    }

    public static function displayHeightGivenInches( $inches )
    {
    	$ft 	=  floor( $inches / 12 );
    	$in		=   $inches % 12;
    	return $ft.'\'  '.$in.'\'\''  ;
    }

    public static function userid()
    {
        $front = Zend_Controller_Front::getInstance();
        $id = null == $front->getRequest()->getParam('talentnum') ? $front->getRequest()->getParam('id') : $front->getRequest()->getParam('talentnum');

        if ( isset($id) && (!LOGGEDIN)){
            $userid = $id;
        } else {
            $userid = USERID;
        }
        return $userid;
    }

    // 1 = online  2 = offline
	public static function getOnline($talent)
	{
		$model = new Online_Model_Etonline();
		$online = $model->fetchAll('talentnum = '.$talent, null, null);

		if ($online){
			if ( $online->getType() == 1 ){
				return true;
			} else {
				return false;
			}
		}
	}

	public static function setRestype($result)
	{
		$model = new Resources_Model_Resources();
		return $model->setRestype($result);
	}

	// format a phone number from a user input
    public static function phoneClean($data)
    {
   		$pattern = '/\D*\(?(\d{3})?\)?\D*(\d{3})\D*(\d{4})\D*(\d{1,8})?/';

   		if (preg_match($pattern, $data, $match)){
      		if ($match[3]){
         		if ($match[1]){
            		$num = $match[1].$match[2].$match[3];
         		}else{
            		$num = $match[2].'-'.$match[3];
         		}
	      	}else{
	         	$num = NULL;
	      	}
	      	isset($match[4]) ? $ext = $match[4] : $ext = NULL;
   		}else{
      		$num = NULL;
      		$ext = NULL;
   		}
   		$clean = array($num,$ext);
   		return $clean;
	}

	public static function tenDigitsPhone($data)
	{
		return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
	}

	public static function arrayObj($obj)
	{
		if(!is_array($obj)){
            $data[0] = $obj;
        } else {
            $data = $obj;
        }

        return $data;
	}

	/**
	 * find out nr of friends
	 * @return boolean
	 */
	public static function fetchFriends()
	{
		$model = new Friendsnotification_Model_Etfriendsnotification();
		$friend = $model->fetchAll('to_id = '.USERID, null, null);

		return $friend ;
	}

    public static function getTalentSub($talentnum)
    {
        $number = floor($talentnum/10000);
        $number = str_pad($number, 3, "0", STR_PAD_LEFT);
        return $number;
    }

	public static function getAgeYear($talentnum)
	{
		$tf1 = new Talents_Model_Talentinfo1(); $tf1->useDependents(false);
		$getAge = $tf1->fetchAll('talentnum = '.$talentnum);

		return $getAge != null ? static::getAge($getAge->getDobmm(),$getAge->getDobdd(), $getAge->getDobyyyy()) : 'n/a';
	}

    public static function getName($talentnum)
    {
        if ($talentnum){
            $model = new Talents_Model_Talentci();
			$model->useDependents(false);
			$model->usePaginator(false);

	        $ftsearch = new Talents_Model_Ftsearch();
	        $featured = $ftsearch->fetchAll('talentnum = '.$talentnum, null, 1);

            $name = $model->fetchAll('talentnum = '.$talentnum, null, null);

            if($name){
                $pro = 'no';
                if($name->getJoinStatus() == 5){
                    $pro = 'pro';
                }
                if($featured != null){
                    $pro = 'featured';
                }

            	return array(
                    'fname'=>$name->getFname(),
                    'lname'=>$name->getLname(),
                    'talentlogin'=>$name->getTalentlogin(),
                    'pro'=>$pro,
                    'talentnum'=>$name->getTalentnum(),
                );
            }
        } else {
            return array('fname'=>'n/a', 'lname'=>'n/a', 'talentlogin'=>'n/a', 'pro'=>'n/a', 'talentnum'=>null);
        }
    }

    public static function getAge($bMonth,$bDay,$bYear)
    {
        if ($bMonth > 0 && $bDay > 0){
            list($cYear, $cMonth, $cDay) = explode("-", date("Y-m-d"));
            return ( ($cMonth >= $bMonth && $cDay >= $bDay) || ($cMonth > $bMonth) ) ? $cYear - $bYear : $cYear - $bYear - 1;
        } else {
            return 'n/a';
        }
    }

    public static function toArray($data)
    {
        $array = array();

        if($data){
            if(is_array($data)){
                $array = $data;
            } else {
                $array[] = $data;
            }
        } else {
            $array = null;
        }

        return $array;
    }

    /*
    * @method: getTimeDuration
    * @param: unix timestamp
    * @return: duration of minutes, hours, days, weeks, months, years
    */
    public static function getTimeDuration($unixTime)
    {
        $secsago   =   time() - $unixTime;

        if ($secsago < 60){
            $period = $secsago == 1 ? '1 second ago'     : $secsago . ' seconds ago';
        }
        else if ($secsago < 3600) {
            $period    =   round($secsago/60);
            $period    =   $period == 1 ? '1 minute ago' : $period . ' minutes ago';
        }
        else if ($secsago < 86400) {
            $period    =   round($secsago/3600);
            $period    =   $period == 1 ? '1 hour ago'   : $period . ' hours ago';
        }
        else if ($secsago < 604800) {
            $period    =   round($secsago/86400);
            $period    =   $period == 1 ? '1 day ago'    : $period . ' days ago';
        }
        else if ($secsago < 2419200) {
            $period    =   round($secsago/604800);
            $period    =   $period == 1 ? '1 week ago'   : $period . ' weeks ago';
        }
        else if ($secsago < 29030400) {
            $period    =   round($secsago/2419200);
            $period    =   $period == 1 ? '1 month ago'   : $period . ' months ago';
        }
        else {
            $period    =   round($secsago/29030400);
            $period    =   $period == 1 ? '1 year ago'    : $period . ' years ago';
        }
    return $period;
    }

    public static function boolSubmission($castingId, $roleId)
    {
        $model = new Notifications_Model_Jobsubmissions();
        $data = $model->fetchAll('talentnum = '.USERID.' AND job_id = '.$castingId.' AND role_id = '.$roleId);

        return $data;
    }

	public static function getStates()
	{
		$states = [null=>'Select One', 'CA'=>'California','AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CO'=>'Colorado',
				   'CT'=>'Connecticut','DE'=>'Delaware','DC'=>'District Of Columbia','FL'=>'Florida','GA'=>'Georgia',
				   'HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois', 'IN'=>'Indiana', 'IA'=>'Iowa','KS'=>'Kansas',
				   'KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland', 'MA'=>'Massachusetts',
				   'MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana',
				   'NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico',
				   'NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma',
				   'OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota',
				   'TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington',
				   'WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming'];

		return $states;
	}

    /**
     * @param $email
     * @return bool
     */
    public static function isValidEmail($email)
    {
        $isValid = true;
        $atIndex = strrpos($email, "@");
        if (is_bool($atIndex) && !$atIndex)
        {
            $isValid = false;
        }
        else
        {
            $domain = substr($email, $atIndex+1);
            $local = substr($email, 0, $atIndex);
            $localLen = strlen($local);
            $domainLen = strlen($domain);
            if ($localLen < 1 || $localLen > 64)
            {
                // local part length exceeded
                $isValid = false;
            }
            else if ($domainLen < 1 || $domainLen > 255)
            {
                // domain part length exceeded
                $isValid = false;
            }
            else if ($local[0] == '.' || $local[$localLen-1] == '.')
            {
                // local part starts or ends with '.'
                $isValid = false;
            }
            else if (preg_match('/\\.\\./', $local))
            {
                // local part has two consecutive dots
                $isValid = false;
            }
            else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
            {
                // character not valid in domain part
                $isValid = false;
            }
            else if (preg_match('/\\.\\./', $domain))
            {
                // domain part has two consecutive dots
                $isValid = false;
            }
            else if
            (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
            {
                // character not valid in local part unless
                // local part is quoted
                if (!preg_match('/^"(\\\\"|[^"])+"$/',
                    str_replace("\\\\","",$local)))
                {
                    $isValid = false;
                }
            }
            if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
            {
                // domain not found in DNS
                $isValid = false;
            }
       }
       return $isValid;
   }

}