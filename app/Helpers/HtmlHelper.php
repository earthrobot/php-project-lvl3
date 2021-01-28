<?php

namespace App\Helpers;

class HtmlHelper
{
    public static function highlightCurrentLink(string $routeName, string $defaultClassName = 'active')
    {
        return \Route::is($routeName) ? $defaultClassName : '';
    }
}
