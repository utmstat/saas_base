<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 31.03.17
 * Time: 0:30
 */

namespace app\components\helpers;

use DateTime;

class DateHelper
{
    public static function getDayTimestamp($timestamp = null)
    {
        if (!is_numeric($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        if (!$timestamp) {
            $timestamp = time();
        }

        return strtotime(date('Y-m-d 00:00:00', $timestamp));
    }

    public static function getNextMondayTimestamp($timestamp = null)
    {
        return strtotime('next monday', self::getDayTimestamp($timestamp));
    }

    public static function getNextMonthTimestamp($timestamp = null)
    {
        return strtotime('+1 month', self::getDayTimestamp($timestamp));
    }

    public static function getPrevMondayTimestamp($timestamp = null)
    {
        return strtotime('previous monday', self::getDayTimestamp($timestamp));
    }

    public static function getThisWeekMondayTimestamp($timestamp = null)
    {
        if (is_string($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        $dataInfo = getdate($timestamp);

        $d = $dataInfo['wday'];

        $map = [
            0 => 6,
            1 => 0,
            2 => 1,
            3 => 2,
            4 => 3,
            5 => 4,
            6 => 5,
        ];

        $result = $timestamp - 86400 * $map[$d];

        return self::formatAsFrom($result);
    }

    public static function getHourTimestamp($timestamp = null)
    {
        if (!is_numeric($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        if (!$timestamp) {
            $timestamp = time();
        }

        return strtotime(date('Y-m-d H:00:00', $timestamp));
    }

    public static function getMinuteTimestamp($timestamp = null)
    {
        if (!is_numeric($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        if (!$timestamp) {
            $timestamp = time();
        }

        return strtotime(date('Y-m-d H:i:00', $timestamp));
    }

    public static function getWeek($timestamp)
    {
        return (int)date('W', $timestamp);
    }

    public static function formatAsFrom($timestamp)
    {
        if (is_string($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        return strtotime(date('Y-m-d 00:00:00', $timestamp));
    }

    public static function formatAsHour($timestamp)
    {
        if (is_string($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        return strtotime(date('Y-m-d H:i:00', $timestamp));
    }

    public static function formatAsTo($timestamp)
    {
        if (is_string($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        return strtotime(date('Y-m-d 23:59:59', $timestamp));
    }

    public static function formatAsDuration($seconds)
    {
        $H = floor($seconds / 3600);
        $i = ($seconds / 60) % 60;
        $s = $seconds % 60;

        if (strlen($H) == 1) {
            $H = '0' . $H;
        }
        if (strlen($i) == 1) {
            $i = '0' . $i;
        }
        if (strlen($s) == 1) {
            $s = '0' . $s;
        }

        return $H . ':' . $i . ':' . $s;
    }

    public static function formatAsTrace($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }

    public static function formatAsPlTransactions($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }

    public static function formatToChDate($timestamp)
    {
        return date('Y-m-d', $timestamp);
    }

    public static function formatToYMDate($timestamp)
    {
        return date('d-m-Y', $timestamp);
    }

    public static function parseRussianDate($date)
    {
        // 1 июня 2019 г.
        $date = trim(str_replace('г.', '', $date));
        $dateParts = explode(' ', $date);
        $dateParts[0] = str_pad($dateParts[0], 2, 0, STR_PAD_LEFT);

        $months = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря',
        ];

        $dateParts[1] = str_replace(array_values($months), array_keys($months), $dateParts[1]);
        $dateParts[1] = str_pad($dateParts[1], 2, 0, STR_PAD_LEFT);

        return date('Y-m-d', strtotime(implode('.', $dateParts)));
    }

    public static function getDayByIndex($index)
    {

        if ($index > 7) {
            $index = date('N', $index);
        }

        $days = [
            1 => 'Пн',
            2 => 'Вт',
            3 => 'Ср',
            4 => 'Чт',
            5 => 'Пт',
            6 => 'Сб',
            7 => 'Вс',
        ];

        return $days[$index];
    }

    public static function getMonthByIndex($index)
    {
        if ($index > 12) {
            $index = date('n', $index);
        }

        $months = [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        ];

        return $months[$index];
    }

    public static function getMonthShortByIndex($index)
    {
        if ($index > 12) {
            $index = date('n', $index);
        }

        $months = [
            1 => 'Янв',
            2 => 'Фев',
            3 => 'Мар',
            4 => 'Апр',
            5 => 'Май',
            6 => 'Июн',
            7 => 'Июл',
            8 => 'Авг',
            9 => 'Сен',
            10 => 'Окт',
            11 => 'Ноя',
            12 => 'Дек',
        ];

        return $months[$index];
    }

    public static function getMonthByIndex2($index)
    {
        $months = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря',
        ];

        return $months[$index];
    }

    public static function getFullHour($hour)
    {
        if (strlen($hour) == 1) {
            $result = '0' . $hour . ':00';
        } else {
            $result = $hour . ':00';
        }

        return $result;
    }

    public static function getStartAndEndDate($week, $year = 2017)
    {
        $dto = new DateTime();
        $ret['week_start'] = strtotime($dto->setISODate($year, $week)->format('Y-m-d'));
        $ret['week_end'] = strtotime($dto->modify('+6 days')->format('Y-m-d'));

        return $ret;
    }

    public static function getParseRange($from, $to, $period = 6)
    {
        $result = [];
        $from = self::formatAsFrom($from);
        $to = self::formatAsTo($to);
        $step = 86400 * ($period - 1);
        $dateTo = null;
        $yesterdayTs = time() - 86400;
        for ($ts = $from; $ts <= $to; $ts += ($step + 86400)) {
            if ($ts > $yesterdayTs) {
                break;
            }
            if ($dateTo) {
                $dateFrom = $dateTo + 1;
            } else {
                $dateFrom = self::formatAsFrom($ts);
            }
            $toTs = min($yesterdayTs, $ts + $step, $to);
            $dateTo = self::formatAsTo($toTs);
            $result[] = [
                'from' => $dateFrom,
                'to' => $dateTo,
                'period' => ceil(($dateTo - $dateFrom) / 86400)
            ];
        }

        return $result;
    }


    public static function formatToChartDate($ts)
    {
        return date('Y-m-d', $ts);
    }

    public static function formatToChartDateH($ts)
    {
        return date('Y-m-d H', $ts);
    }

    public static function getFirstDayOfMonth($ts = null)
    {

        if (!$ts) {
            $ts = time();
        }

        if (!is_numeric($ts)) {
            $ts = strtotime($ts);
        }
        $dateInfo = getdate($ts);
        return strtotime($dateInfo['year'] . '-' . $dateInfo['mon'] . '-01 00:00:00');
    }

    public static function getLastDayOfMonth($ts = null)
    {
        if (!$ts) {
            $ts = time();
        }

        $lastday = date('t', $ts);
        $dateInfo = getdate($ts);
        return strtotime($dateInfo['year'] . '-' . $dateInfo['mon'] . '-' . $lastday . ' 23:59:59');
    }

    public static function getPrevWeekDates($index)
    {
        $d = strtotime("+" . $index . " week -1 day");
        $start_week = strtotime("last monday midnight", $d);
        $end_week = strtotime("next sunday", $d);
        $start = strtotime(date("Y-m-d", $start_week));
        $end = strtotime(date("Y-m-d", $end_week));

        return [
            'from' => self::formatAsFrom($start),
            'to' => self::formatAsTo($end)
        ];
    }

    public static function getLastMonthList($count = 12)
    {
        $result = [];

        for ($i = 0; $i < $count; $i++) {
            $m = date('n');
            $y = date('Y');
            $mts = strtotime($y . '-' . $m . '-15 00:00:00');
            $ts = self::getFirstDayOfMonth($mts - $i * 86400 * 30);
            $result[] = [
                'ts' => $ts,
                'date' => self::formatAsTrace($ts),
                'title' => date('M, Y', $ts)
            ];
        }
        return $result;
    }

    /**
     * @param $from
     * @param $to
     * @return float|int
     */
    public static function getDiffDaysCount($from, $to)
    {
        return ceil(($to - $from) / 86400);
    }

    public static function getMonth($ts)
    {
        return date('M', $ts);
    }

    /**
     * Дата списания
     *
     * @param null $ts
     *
     * @return false|int
     */
    public static function getChargeDate($ts = null)
    {
        if (!$ts) {
            $ts = time();
        }
        $cts = self::getLastDayOfMonth($ts);
        $data = getdate($cts);
        return $data['mday'] . ' ' . self::getMonthByIndex2($data['mon']);
    }

    /**
     * Get hours list for dropdown
     * @return array
     */
    public static function getHoursList()
    {
        $items = [
            '00' => '00',
            '01' => '01',
            '03' => '03',
            '04' => '04',
            '05' => '05',
            '06' => '06',
            '07' => '07',
            '08' => '08',
            '09' => '09',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
        ];

        return $items;
    }

    /**
     * Get last week number
     * @param int $timestamp
     * @return int
     */
    public static function getLastWeekNumber($timestamp)
    {
        return (int)date('W', strtotime(date('Y-12-28', $timestamp))); // ISO Says that last week will contain 28th of December
    }

    /**
     * Get week number
     * @param $timestamp
     * @return int
     */
    public static function getWeekNumber($timestamp)
    {
        if (date('Y-m-d', $timestamp) >= date('Y-12-28', $timestamp)) {
            return self::getLastWeekNumber($timestamp);
        }
        return (int)date('W', $timestamp);
    }

    public static function formatTimeString($timeStamp)
    {
        $str_time = date("Y-m-d H:i:sP", $timeStamp);
        $time = strtotime($str_time);
        $d = new DateTime($str_time);

        $weekDays = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вск'];
        $months = ['Янв', 'Фев', 'Мар', 'Апр', ' Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];

        if ($time > strtotime('-2 minutes')) {
            return 'Только что';
        } elseif ($time > strtotime('-59 minutes')) {
            $min_diff = floor((strtotime('now') - $time) / 60);
            return $min_diff . ' мин' . (($min_diff != 1) ? "" : "") . ' назад';
        } elseif ($time > strtotime('-23 hours')) {
            $hour_diff = floor((strtotime('now') - $time) / (60 * 60));
            return $hour_diff . ' час' . (($hour_diff != 1) ? "а" : "") . ' назад';
        } elseif ($time > strtotime('today')) {
            return $d->format('G:i');
        } elseif ($time > strtotime('yesterday')) {
            return 'Вчера в ' . $d->format('G:i');
        } elseif ($time > strtotime('на этой неделе')) {
            return $weekDays[$d->format('N') - 1] . ' в ' . $d->format('G:i');
        } else {
            return $d->format('j') . ' ' . $months[$d->format('n') - 1] .
                (($d->format('Y') != date("Y")) ? $d->format(' Y') : "") .
                ' at ' . $d->format('G:i');
        }
    }

    public static function getDayOfMonth($ts = null)
    {
        if (!$ts) {
            $ts = time();
        }
        return date('j', $ts);
    }
}
