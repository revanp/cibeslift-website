<?php

if(!function_exists('getLocale')) {
    function getLocale()
    {
        return app()->getLocale();
    }
}

if(!function_exists('urlLocale')) {
    function urlLocale($link)
    {
        return url(app()->getLocale() . '/'.$link);
    }
}
