<?php

namespace app\services;

/**
 * Description of StringService
 *
 * @author leadmitry <leadmitry@gmail.com>
 */
class StringService
{

    public static function mb_ucfirst($text)
    {
        mb_internal_encoding("UTF-8");

        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

}
