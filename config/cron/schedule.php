<?php

use omnilight\scheduling\Schedule;

/**
 * @var Schedule $schedule
 */

$chunks = explode('=', $_SERVER['argv']['3']);
$task = (int)$chunks[1];


//switch ($task) {
//    case 100:
//        $schedule->command('monitoring')->everyMinute()->withoutOverlapping();
//        break;
//
//}
