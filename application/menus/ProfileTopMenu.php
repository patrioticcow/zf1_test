<?php

// not used. See TopmenuController

class Application_Menu_ProfileTopMenu
{

	public static function getSubMenuRight($type = 'visitor')
	{
		$userid =  Application_Model_Functions::userid();

		//
		$friends = Application_Model_Functions::fetchFriends();
		$friendsCount = count($friends);

		$model = new Profile_Model_Messages(); $model->useDependents(false);
		$messageData = $model->fetchAll('too = '.$userid);
		$messagesCount = count($messageData);

		$totalCount = $messagesCount + $friendsCount;

		//
		$models = new Profile_Model_Profileviews(); $models->useDependents(false);
		$dataViewed = count( $models->parseData('viewed', 1) );
		$dataViews = count( $models->parseData('views', 1) );

		//get saved jobs
		$savedModel = new Notifications_Model_Savedjobs(); $savedModel->useDependents(false);
		$fetcsSaved = count($savedModel->fetchAll('talentnum = '.$userid));

		//$totalViews = $dataViewed + $dataViews + $fetcsIntOne + $fetcsIntTwo + $fetcsIntThree;
		$totalViews = $dataViewed;

        $xModel = new Auditions_Model_SubTalentSubmissions(USERID);
        $submissions = count($xModel->fetchAll('sub_type = 2'));

		$listCount = $fetcsSaved + $submissions;


		$container = '
			<ul class="stn-menu stn-menu-style red">

				<li class="hasSubNav hasArrow">
					<a href="javascript:;"><span class="icon_friend_not">'.$totalCount.'</span></a>
					<ul>
						<li><a href="/friendsnotification/index/index/id/'.$userid.'">Friend Request '.$friendsCount.'</a></li>
						<li><a href="/profile/index/messages/id/'.$userid.'">Messages '.$messagesCount.'</a></li>
						<li><a href="/friendsnotification/index/email-my-profile/'.$userid.'">Email My Profile</a></li>
						<li><a href="/friendsnotification/index/email-referrals/'.$userid.'">Email Referrals</a></li>
						<li><a href="http://mail.exploretalent.com/src/login.php">Check Email</a></li>
					</ul>

				</li>
				<li class="hasSubNav hasArrow">
					<a href="javascript:;"><span class="icon_message_not">'.$totalViews.'</span></a>
					<ul>
						<li><a href="/friends/index/view/id/'.$userid.'">My Friends</a></li>
						<li><a href="/fans/index/view/id/'.$userid.'">My Likes/Fans</a></li>
						<li><a href="/friends/index/get-more-friends/id/'.$userid.'">Get more Friends</a></li>
						<li><a href="/online">Members Online</a></li>
						<li><a href="/activityfeed">People Activity</a></li>
						<li><a href="/join/index/now">Who just joined ET</a></li>
						<li><a href="/testimonials">Testimonials</a></li>
						<li><a href="/profile/viewed/'.$userid.'">Profiles I Viewed '.$dataViewed.'</a></li>
						<li><a href="/profile/views/'.$userid.'">Viewed My Profile '.$dataViews.'</a></li>
					</ul>
				</li>
				<li class="hasSubNav hasArrow">
					<a href="javascript:;"><span class="icon_more_not">'.$listCount.'</span></a>
					<ul>
						<li><a href="/search/acting">Auditions & Jobs</a></li>
						<li><a href="/notifications/index/myjobs/id/'.$userid.'">My Saved jobs '.$fetcsSaved.'</a></li>
						<li><a href="/notifications/index/submissions/id/'.$userid.'">My Submissions '.$submissions.'</a></li>
						<li><a href="/notifications/index/submission-calendar/'.$userid.'">Submission Calendar</a></li>
						<li><a href="/notifications/index/castings-jobs-preferences/id/'.$userid.'">Casting/Job Preferences</a></li>
						<li><a href="/about/how-to-get-votes">How to get Points/Votes</a></li>
						<!--li><a href="/profile/audio/'.$userid.'">My Playlist</a></li-->
						<li><a href="/about/industry">Industry Terms</a></li>
						<li><a href="/auditions/index/industry">Industry Resources</a></li>
					</ul>
				</li>

			</ul>
		';

		return $container;
	}

}