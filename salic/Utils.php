<?php

namespace salic;


class Utils
{
    /*
     * generate the href attribute for the pages
     * (adds a 'href' => '...' to each page array)
     */
    public static function generatePageHrefs(array &$pages, $baseUrl)
    {
        foreach ($pages as $key => &$page) {
            $page['href'] = $baseUrl . $key;
        }
    }

    public static function returnHttpError($code, $msg = false)
    {
        http_response_code($code);

        if ($msg)
            die($msg);
        else
            die();
    }
}