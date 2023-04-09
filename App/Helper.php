<?php
namespace App;

class Helper
{
    public static function getPagination() : int
    {
        return Settings::PAGINATION;
    }
    public static function getSortBy() : string
    {
        $sortBy = filter_input(INPUT_GET,'sortBy',FILTER_SANITIZE_SPECIAL_CHARS);
        if($sortBy) {
            $sortBy = strtolower($sortBy);
            if(!in_array($sortBy, ['name', 'email', 'status'])) {
                $sortBy = 'id';
            }
        }
        else {
            $sortBy = 'id';
        }
        return $sortBy;
    }
    public static function getSortOrder() : string
    {
        $sortOrder = filter_input(INPUT_GET,'sortOrder',FILTER_SANITIZE_SPECIAL_CHARS);
        if($sortOrder) {
            $sortOrder = strtolower($sortOrder);
            if(!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }
        }
        else {
            $sortOrder = 'desc';
        }
        return $sortOrder;
    }
    public static function getCurPage() : int
    {
        $page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_NUMBER_INT);
        return ($page) ? $page : 1;
    }
    public static function getSortUrl($url, $name) : string
    {
        $query_params = [];
        $url_parts = parse_url($url);
        if(isset($url_parts['query'])) {
            parse_str($url_parts['query'], $query_params);
        }

        $query_params['sortBy'] = $name;
        if(array_key_exists('sortOrder',$query_params)) {
            $query_params['sortOrder'] = $query_params['sortOrder'] == 'asc' ? 'desc' : 'asc';
        } else {
            $query_params['sortOrder'] = 'asc';
        }
        $url_parts['query'] = http_build_query($query_params);
        return $url_parts['path'] . '?' . $url_parts['query'];
    }

    public static function getPageUrl($url, $page) : string
    {
        $query_params = [];
        $url_parts = parse_url($url);
        if(isset($url_parts['query'])) {
            parse_str($url_parts['query'], $query_params);
        }

        $query_params['page'] = $page;
        $url_parts['query'] = http_build_query($query_params);
        return $url_parts['path'] . '?' . $url_parts['query'];
    }
    // Filters
    public static function filterString($string) : string
    {
        return filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public static function filterInt($int) : int
    {
        return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
    }
    public static function filterEmail($email) : string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}