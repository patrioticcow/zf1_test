<?php

abstract class Application_Model_Seo
{
    /**
     * @param string $string
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getSeoKeywords($string, $prefix = null, $suffix = null)
    {
        $prefix = empty($prefix) ? 'modeling, acting auditions, casting calls' : $prefix;
        $suffix = empty($suffix) ? 'auditions, modeling, auditions, movie, actress, become, a, model, pageants, talent, search, baby, modeling, acting, for, kids, jordan, model, talent, exploretalent, talent, model, search'
            : $suffix;

        return self::normalizeKeywords($prefix . ' ' . $string . ' ' . $suffix);
    }

    /**
     * @param $keyword
     * @param string $delim
     * @return string
     */
    public static function normalizeKeywords($keyword, $delim = ', ')
    {
        $keyword = preg_replace('/[^a-zA-Z0-9-_ ]/s', '', $keyword);
        $keywords = explode(' ', trim(strtolower($keyword)));
        foreach ($keywords as $key=>$kw) {
            if (trim($kw) == '') {
                unset ($keywords[$key]);
            }
        }
        $keyword = implode('-', $keywords);
        $keywords = explode('-', trim(strtolower($keyword)));
        foreach ($keywords as $key=>$kw) {
            if (trim($kw) == '' || trim($kw) == '-') {
                unset ($keywords[$key]);
            }
        }
        $keyword = implode('_', $keywords);
        $keywords = explode('_', trim(strtolower($keyword)));
        foreach ($keywords as $key=>$kw) {
            if (trim($kw) == '' || trim($kw) == '_') {
                unset ($keywords[$key]);
            }
        }
        return implode($delim, $keywords);
    }

    /**
     * @param string $string
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function getSeoDescription($string, $prefix = null, $suffix = null)
    {
        $suffix = empty($suffix) ? 'auditions modeling agency at ExploreTalent.com'
            : $suffix;
        return trim("{$prefix} {$string} {$suffix}");
    }


    public static function getProfileCanonicalLink($username = null)
    {
        return   '/' . $username;
    }

    public static function getProfileLinksCanonicalLink($talentnum = null)
    {
        return   '/profile/links/' . $talentnum;
    }

    public static function getProfileResumeCanonicalLink($talentnum = null)
    {
        return   '/resume/view/' . $talentnum;
    }


    public static function cleanConvertISO88591toUTF8($str)
    {
        //@todo: add more features like encoding detection prior to conversion
        return iconv("ISO-8859-1", "UTF-8//TRANSLIT", $str);
    }
}