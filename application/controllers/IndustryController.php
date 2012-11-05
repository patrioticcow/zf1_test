<?php
class IndustryController extends Zend_Controller_Action
{

	public function init()
	{
		$auth = Zend_Auth::getInstance();
        $this->userObj = $userObj = $auth->getStorage()->read();
        $this->view->title = "Resources";
        $this->_helper->layout->setLayout('default');
	}

	public function indexAction(){}

	public function celebritiesExclusiveInterviewsAction(){}
	public function piersMorganAction(){
		$this->view->headTitle("Piers Morgan Celebrity Apprentice Exclusive Interviewss &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function aaronCarterAction(){
		$this->view->headTitle("Aaron Carter Celebrity Apprentice Exclusive Interviewss &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Aaron Carter,aaron carter lyrics,aaron carter candy,aaron carter songs, nick and aaron carter" );
		$this->view->headMeta()->appendName('description', "Aaron Carter Celebrity Interviews &amp; advice, auditions, modeling, casting, talent agency, baby modeling, acting jobs, baby model, auditions, movie, teen models, agency, casting call, casting, asian model find" );
	}
	public function acrockettinterviewAction(){
		$this->view->headTitle("Affion Crockett Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function adeleAction(){
		$this->view->headTitle("Adele Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function albsureinterviewAction(){
		$this->view->headTitle("Al B Sure  Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function arielTwetoAction(){
		$this->view->headTitle("Ariel Tweto Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function benjaminButtonMadisenBeatyAction(){
		$this->view->headTitle("Madisen Beatty The Curious Case of Benjamin Button - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function beyedpinterviewAction(){
		$this->view->headTitle("Black Eyed Peas Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function blackEyedPeasAction(){
		$this->view->headTitle("Black Eyed Peas Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function bmcknightinterviewAction(){
		$this->view->headTitle("Black Eyed Peas Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function bobbybrowninterviewAction(){
		$this->view->headTitle("Bobby Brown Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function californicationMadelineZimaAction(){
		$this->view->headTitle("Californication Madeline Zima Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function cassandrawilsonAction(){
		$this->view->headTitle("Cassandra Wilson Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function cocaineinterviewAction(){
		$this->view->headTitle("Cocaine Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function daveGrohlAction(){
		$this->view->headTitle("Dave Grohl Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function davidAlanGrierAction(){
		$this->view->headTitle("David Alan Grier Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function davidchardasAction(){
		$this->view->headTitle("David Chardas - Los Volcanes Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function davidBannerAction(){
		$this->view->headTitle("David Banner Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "David Banner, how to become a singer, learn how to become a famous rapper artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "David Banner on Explore Talent. Learn how to become a singer and singer like David Banner. Listen to David Banner Video for tips on how to become a famous rapper artist." );
	}
	public function ditchinterviewAction(){
		$this->view->headTitle("Ditch Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function djdramainterviewAction(){
		$this->view->headTitle("DJ Drama Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function donwasAction(){
		$this->view->headTitle("Don Was Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function dwaineStevensonAction(){
		$this->view->headTitle("Dwaine Stevenson Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function eddierodriguezAction(){
		$this->view->headTitle("Dwaine Stevenson Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function envogueinterviewAction(){
		$this->view->headTitle("En Vogue Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function ericbenetAction(){
		$this->view->headTitle("Eric Benet Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function etceterainterviewAction(){
		$this->view->headTitle("Etcetera Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function gabrielleUnionAction(){
		$this->view->headTitle("Gabrielle Union Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "megan good, gabriel union, gabriella union, gabrielle union, union gabrielle, gabrielle union wade, wade and gabrielle union, gabrielle union and wade, wade gabrielle union, d wade gabrielle union, gabrielle union and d wade, dwyane wade and gabrielle union, gabrielle union and dwyane wade, dwayne wade and gabrielle union, dwayne wade gabrielle union, dwayne wade & gabrielle union, dwyane wade & gabrielle union, gabrielle union & dwyane wade, dwyane wade with gabrielle union, dwyane wade gabrielle union, gabrielle union dwyane wade, d wade and gabrielle union, dwayne and gabrielle union, gabrielle union and dwayne, gabrielle union dwayne, gabrielle union and dwayne wade, gabrielle union dwayne wade, gabrielle union pics" );
		$this->view->headMeta()->appendName('description', "Gabrielle Union Exclusive Celebrity Interviews &amp; advice auditions modeling casting talent agency baby modeling acting jobs baby model auditions movie teen models agency casting call casting asian model find" );
	}
	public function gunsNRosesAction(){
		$this->view->headTitle("Guns N' Roses Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Guns N' Roses, how to become a singer, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Guns N' Roses on Explore Talent. Learn how to become a singer and singer like Guns N' Roses. Listen to Guns N' Roses Video for tips on how to become a famous  artist." );
	}
	public function hiphopExclusiveInterviewsAction(){
		$this->view->headTitle("Explore Talent | Exclusive Celebrity Interviews & Expert Advice" );
		$this->view->headMeta()->appendName('keywords', "exclusive interviews, celebrity interviews, expert advice, modeling jobs, acting auditions, casting calls, explore talent, exploretalent, exploretalent.com" );
		$this->view->headMeta()->appendName('description', "Explore Talent | Exclusive Celebrity Interviews & Expert Advice | Acting Auditions, Modeling, Modeling Jobs & Casting Calls - On ExploreTalent.com" );
	}
	public function jadakissinterviewAction(){
		$this->view->headTitle("Jadakiss Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function jamieFoxxAction(){
		$this->view->headTitle("Jamie Foxx Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Jamie Foxx, how to become an actor, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Jamie Foxx on Explore Talent. Learn how to become an actor  like Jamie Foxx. Listen to Jamie Foxx Video for tips on how to become a famous  artist." );
	}
	public function jconwayinterviewAction(){
		$this->view->headTitle("Jimmy Conway Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function jenniaFredriqueAction(){
		$this->view->headTitle("Jennia Fredrique Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Jennia Fredrique, how to become an actor, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Jennia Fredrique on Explore Talent. Learn how to become an actor  like Jennia Fredrique. Listen to Jennia Fredrique Video for tips on how to become a famous  artist." );
	}
	public function joanRiversAction(){
		$this->view->headTitle("Joan Rivers Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Joan Rivers, how to become an actor, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Joan Rivers on Explore Talent. Learn how to become an actor  like Joan Rivers. Listen to Joan Rivers Video for tips on how to become a famous  artist." );
	}
	public function jonasbrothersAction(){
		$this->view->headTitle("Joan Rivers Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Joan Rivers, how to become an actor, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Joan Rivers on Explore Talent. Learn how to become an actor  like Joan Rivers. Listen to Joan Rivers Video for tips on how to become a famous  artist." );
	}
	public function johnnygilinterviewAction(){
		$this->view->headTitle("Johnny Gil Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function karinaSmirnoffAction(){
		$this->view->headTitle("Karina Smirnoff Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Karina Smirnoff, Karina dance with the stars, dancing with the stars cast, dancing with the stars hosts, dancing with stars, stars dancing, celebrity profile for Karina, celb profile for Karina Smirnoff, world's second best dancer, recent dancer to win awards, ukranian american famous dancer, ukranian famous dancer, beautiful famous dancer" );
		$this->view->headMeta()->appendName('description', "Karina Smirnoff Exclusive Celebrity Interviews &amp; advice auditions modeling casting talent agency baby modeling acting jobs baby model auditions movie teen models agency casting call casting asian model find" );
	}
	public function karadioguardiAction(){
		$this->view->headTitle("Karina Smirnoff Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Karina Smirnoff, Karina dance with the stars, dancing with the stars cast, dancing with the stars hosts, dancing with stars, stars dancing, celebrity profile for Karina, celb profile for Karina Smirnoff, world's second best dancer, recent dancer to win awards, ukranian american famous dancer, ukranian famous dancer, beautiful famous dancer" );
		$this->view->headMeta()->appendName('description', "Karina Smirnoff Exclusive Celebrity Interviews &amp; advice auditions modeling casting talent agency baby modeling acting jobs baby model auditions movie teen models agency casting call casting asian model find" );
	}
	public function keriHilsonAction(){
		$this->view->headTitle("Keri Hilson Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Keri Hilson, how to become a singer, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Keri Hilson on Explore Talent. Learn how to become a singer  like Keri Hilson. Listen to Keri Hilson Video for tips on how to become a famous  artist." );
	}
	public function mamsinterviewAction(){
		$this->view->headTitle("Mams Taylor Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function mariointerviewAction(){
		$this->view->headTitle("Mario Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function mattDamonAction(){
		$this->view->headTitle("Matt Damon Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Matt Damon Movies, Matt Damon Video, How To Become Famous" );
		$this->view->headMeta()->appendName('description', "Matt Damon an American actor, screenwriter, and philanthropist whose career was launched with the success of the film Good Will Hunting, now viewed as one of the sexiest men alive." );
	}
	public function meatloafAction(){
		$this->view->headTitle("Meat Loaf Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function methodmaninterviewAction(){
		$this->view->headTitle("Method Man Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function ravenSymoneAction(){
		$this->view->headTitle("Raven Symone Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Raven Symone, how to become a singer, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Raven Symone on Explore Talent. Learn how to become a singer  like Raven Symone. Listen to Raven Symone Video for tips on how to become a famous  artist." );
	}
	public function rayjinterviewAction(){
		$this->view->headTitle("Ray J Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function redmaninterviewAction(){
		$this->view->headTitle("Redman Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function seanKingstonAction(){
		$this->view->headTitle("Sean Kingston Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Sean Kingston, Augmented Reality, Sean Kingston Sing Along with Lil Sean, Sean Kingston Karaoke, Karaoke Video Fire Burning, Lil Sean, 3D Sean, 3D Sean Kingston, Virtual Sean, Virtual Sean Kingston, Sean Kingston Celebrity Page" );
		$this->view->headMeta()->appendName('description', "Sean Kingston Exclusive Celebrity Interviews &amp; advice auditions modeling casting talent agency baby modeling acting jobs baby model auditions movie teen models agency casting call casting asian model find" );
	}
	public function shannonElizabethAction(){
		$this->view->headTitle("Redman Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function sleepybinterviewAction(){
		$this->view->headTitle("Sleepy Brown Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function slumdogMillionaireAnilKapoorAction(){
		$this->view->headTitle("Slumdog Millionaire Anil Kapoor Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}

	public function snoopDoggAction(){
		$this->view->headTitle("Snoop Dogg Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function snoopdoggdrummerAction(){
		$this->view->headTitle("Carlos McSwain Snoop Dogg Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function snoopdoggembedAction(){
		$this->view->headTitle("Snoop Dogg Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function souljaboyinterviewAction(){
		$this->view->headTitle("Soulja Boy Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function steveoAction(){
		$this->view->headTitle("Steve-O Beverly Hills Film Festival Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function swayinterviewAction(){
		$this->view->headTitle("Sway Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function templateIndustryCelebsAction(){
		$this->view->headTitle("Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function terenceblanchardAction(){
		$this->view->headTitle("Terence Blanchard Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function treySongzAction(){
		$this->view->headTitle("Trey Songz Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Trey Songz , how to become a singer, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Trey Songz on Explore Talent. Learn how to become a singer  like Trey Songz . Listen to Trey Songz Video for tips on how to become a famous  artist." );
	}
	public function tylerPerryAction(){
		$this->view->headTitle("Tyler Perry Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Tyler Perry, how to become a actor, learn how to become a famous  artist, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Tyler Perry on Explore Talent. Learn how to become a actor  like Tyler Perry. Listen to Tyler Perry Video for tips on how to become a famous  artist." );
	}
	public function urgeoverkillAction(){
		$this->view->headTitle("Urge Overkill Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function usherRaymondAction(){
		$this->view->headTitle("Usher Raymond Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "Usher Raymond, how to become a singer, learn how to become a famous artist, dancer and actor, singing, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Usher Raymond on Explore Talent. Learn how to become a dancer and singer like Usher Raymond. Listen to Usher Raymond Video for tips on how to become a famous artist." );
	}
	public function vanessaAndAngelaSimmonsAction(){
		$this->view->headTitle("Vanessa and Angela Simmons: Learn about Vanessa Simmons and Angela Simmons on Explore Talent" );
		$this->view->headMeta()->appendName('keywords', "Vanessa and Angela Simmons, how to become a singer, learn how to become a famous singer, singing, modeling studio, singing studio, dance studios" );
		$this->view->headMeta()->appendName('description', "Vanessa and Angela Simmons on Explore Talent. Learn how to become a singer like Vanessa and Angela Simmons. Listen to Vanessa and Angela Simmons Video for tips on how to become a famous singer." );
	}
	public function viinterviewAction(){
		$this->view->headTitle("Ray J Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function wutanginterviewAction(){
		$this->view->headTitle("Wu Tang Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}
	public function yroscoeinterviewAction(){
		$this->view->headTitle("Yroscoe Exclusive Celebrity Interviews &amp; Advice - Celebrity Video Messages to Explore Talent Members" );
		$this->view->headMeta()->appendName('keywords', "" );
		$this->view->headMeta()->appendName('description', "" );
	}

}