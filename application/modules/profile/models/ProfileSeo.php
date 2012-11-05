<?php

abstract class Profile_Model_ProfileSeo
{
    public static function putSeo($talent = null, $what = "acting")
    {
        if (!empty($talent) && is_object($talent)) {
            $talentSeoData = $talent->getFname() . ' ' .
                $talent->getLname() . ' from ' .
                $talent->getCity() . ' ' .
                $talent->getState()  .  ' ' .
                $talent->getZip() . ' ' .
                $talent->getSex();
            $what = ucfirst($what);
            $view =  Zend_Layout::getMvcInstance()->getView();

            $view->headTitle("Explore Talent|" . $talentSeoData . "|Talent $what Profile"); //seo
            $view->headMeta()->appendName('keywords', Application_Model_Seo::normalizeKeywords("Talent $what Profile for Modeling Acting Auditions Casting Calls | " . $talentSeoData . "modeling, acting auditions, casting calls, Explore, Talentmodeling, acting, modeling, audition, modeling, baby, modeling, auditions, become, a, model, talent, search, actress, photo, american, idol, audition, agency, casting, jobs, la")); //seo
            $view->headMeta()->appendName('description', "Explore Talent | $talentSeoData Talent $what Profile"); //seo

            $canonical_link = self::getProfileTalentCanonicalLink($talent->getTalentnum(), $what);
            $view->headLink(
                array(
                    'rel' => 'canonical',
                    'href' => $canonical_link
                ),
                'PREPEND'
            );
        }
    }
    public static function putSocialSeo($talent = null)
    {
        if (!empty($talent) && is_object($talent)) {
            $talentSeoData = $talent->getFname() . ' ' .
                $talent->getLname() . ' from ' .
                $talent->getCity() . ' ' .
                $talent->getState()  .  ' ' .
                $talent->getZip() . ' ' .
                $talent->getSex();

            $view =  Zend_Layout::getMvcInstance()->getView();

            $view->headTitle($talent->getFname() . ' ' . $talent->getLname() . " on ExploreTalent.com"); //seo
            $view->headMeta()->appendName('keywords', Application_Model_Seo::normalizeKeywords("Talent Social Profile for Modeling Acting Auditions Casting Calls | " . $talentSeoData . "modeling, acting auditions, casting calls, Explore, Talentmodeling, acting, modeling, audition, modeling, baby, modeling, auditions, become, a, model, talent, search, actress, photo, american, idol, audition, agency, casting, jobs, la")); //seo
            $view->headMeta()->appendName('description', "Explore Talent | $talentSeoData | Talent Social Profile for Modeling Acting Auditions Casting Calls"); //seo

            $canonical_link = Application_Model_Seo::getProfileCanonicalLink($talent->getTalentlogin());
            $view->headLink(
                array(
                    'rel' => 'canonical',
                    'href' => $canonical_link
                ),
                'PREPEND'
            );
        }
    }

    public static function getProfileTalentCanonicalLink($userId = null, $what = 'social')
    {
        switch ($what) {
            case "acting":
                return '/profile/acting/' . $userId;
                break;
            case "modeling":
                return   '/profile/modeling/' . $userId;
                break;
            case "dance":
                return   '/profile/dance/' . $userId;
                break;
            case "musician":
                return   '/profile/musician/' . $userId;
                break;
            case "crew":
                return   '/profile/crew/' . $userId;
                break;
            case "sports":
                return   '/profile/sports/' . $userId;
                break;
            default:
                return   '/profile/acting/' . $userId;
                break;
        }
    }

}