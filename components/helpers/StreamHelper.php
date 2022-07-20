<?php

namespace app\components\helpers;

class StreamHelper
{
    /**
     * @param $from
     * @param $to
     * @return int
     */
    public static function generateStreamId($from, $to)
    {
        return rand($from, $to);
    }

}