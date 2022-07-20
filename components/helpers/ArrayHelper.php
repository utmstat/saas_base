<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.06.17
 * Time: 15:55
 */

namespace app\components\helpers;

/**
 * Class ArrayHelper
 * @package app\components\helpers
 */
class ArrayHelper extends \yii\helpers\ArrayHelper
{

    public static function dropDownDownListFormat($array, $keyField, $valueField)
    {
        $result = [];
        foreach ($array as $value) {
            if (is_object($value)) {
                $result[$value->$keyField] = $value->$valueField;
            } else {
                $result[$value[$keyField]] = $value[$valueField];
            }
        }
        return $result;
    }

    public static function addDropDownEmptyValue($array, $title = 'Неважно', $nullIndex = null)
    {
        $result = [];
        $result[$nullIndex] = $title;
        foreach ($array as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public static function getMaxValue($rows, $key)
    {
        $max = null;

        foreach ($rows as $row) {
            $value = (float)$row[$key];
            if (is_null($max)) {
                $max = $value;
            } else {
                $max = max($max, $value);
            }
        }

        return $max;
    }

    public static function getMaxSubValue($rows)
    {
        $max = null;

        foreach ($rows as $row) {
            if (is_null($max)) {
                $max = max($row);
            } else {
                $max = max($max, max($row));
            }
        }

        return $max;
    }

    public static function getItemByField($array, $field, $value)
    {
        $result = null;

        foreach ($array as $item) {
            if ($item[$field] == $value) {
                $result = $item;
                break;
            }
        }

        return $result;
    }

    public static function getSumValue($rows, $key)
    {
        $result = 0;
        foreach ($rows as $row) {
            $result += $row[$key];
        }
        return $result;
    }

    public static function getMaxValue2($rows, $key1, $key2)
    {
        $max = null;

        foreach ($rows as $row) {
            $value = (float)$row[$key1][$key2];
            if (is_null($max)) {
                $max = $value;
            } else {
                $max = max($max, $value);
            }
        }

        return $max;
    }

    public static function getDublicateValue($array, $key)
    {
        $result = self::getValue($array, $key);
        if (is_array($result)) {
            $result = array_shift($result);
        }
        return $result;
    }

    /**
     * @param $str
     * @param string $delimiter
     * @return array
     */
    public static function safeExplode($str, $delimiter = ',')
    {
        $result = [];
        $chunks = explode($delimiter, $str);
        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk) {
                $result[] = $chunk;
            }
        }
        return $result;
    }

    public static function splitByChunks($array, $chunkSize = 10)
    {
        $result = [];
        for ($i = 0, $iMax = count($array); $i < $iMax; $i += $chunkSize) {
            $result[] = array_slice($array, $i, $chunkSize);
        }
        return $result;
    }

    /**
     * Дозаполняет массив чтобы везде одинакове количество индексов
     * @param $array
     * @param int $defaultValue
     * @return mixed
     */
    public static function upToFill($array, $defaultValue = 0)
    {
        $result = $array;
        $keys = [];
        foreach ($result as $values) {
            $keys = array_merge($keys, array_keys($values));
        }

        $keys = array_unique($keys);

        foreach ($result as $k => $values) {
            foreach ($keys as $key) {
                if (!isset($result[$k][$key])) {
                    $result[$k][$key] = $defaultValue;
                }
            }
        }

        return $result;
    }

    public static function fill($from, $to)
    {
        $result = [];

        $from = (int)$from;
        $to = (int)$to;

        for ($i = $from; $i <= $to; $i++) {
            $result[] = $i;
        }

        return $result;
    }

    public static function fillByTimestamp($array, $from, $to, $value = 0)
    {
        $result = $array;

        $from = (int)$from;
        $to = (int)$to;

        for ($ts = $from; $ts <= $to; $ts += 86400) {
            $result[DateHelper::formatAsFrom($ts)] = $value;
        }

        return $result;
    }

    public static function fillByWeekTimestamp($array, $from, $to, $value = 0)
    {
        $result = $array;

        $currentDate = $from;

        while ($currentDate < $to) {
            $year = date('Y', $currentDate);
            $weekNumber = DateHelper::getWeekNumber($currentDate);
            $result[$year . '-' . $weekNumber] = $value;
            $currentDate = strtotime("+1 week", $currentDate);
        }

        return $result;
    }

    public static function fillByMonthTimestamp($array, $from, $to, $value = 0)
    {
        $result = $array;

        $from = (int)$from;
        $to = (int)$to;
        $index = DateHelper::getFirstDayOfMonth($from);

        while ($index < $to) {
            $result[$index] = $value;
            $index = DateHelper::getFirstDayOfMonth(strtotime("+1 month", $index));
        }

        return $result;
    }

    public static function fillByMondayTimestamp($array, $from, $to, $value = 0)
    {
        $result = $array;

        $from = (int)$from;
        $to = (int)$to;
        $index = DateHelper::getThisWeekMondayTimestamp($from);

        while ($index < $to) {
            $result[$index] = $value;
            $index += 86400 * 7;
        }

        return $result;
    }

    public static function fillByHourTimestamp($array, $from, $to, $value = 0)
    {
        $result = $array;

        $from = (int)$from;
        $to = (int)$to;

        for ($ts = $from; $ts <= $to; $ts += 3600) {
            $result[strtotime(date('Y-m-d H:00', $ts))] = $value;
        }

        return $result;
    }

    public static function fillByMonthWeeksMondayTimestamp($array, $monthTs, $value = 0)
    {
        $result = $array;
        $fts = DateHelper::getFirstDayOfMonth($monthTs);
        $lts = DateHelper::getLastDayOfMonth($monthTs);

        for ($ts = $fts; $ts <= $lts; $ts += 86400) {
            $index = DateHelper::getThisWeekMondayTimestamp($ts);
            if ($index >= $fts) {
                $result[$index] = $value;
            }
        }

        return $result;
    }

    public static function fillByWeekDaysTimestamp($array, $weekMondayTs, $value = 0)
    {
        $result = $array;
        $ts = DateHelper::getThisWeekMondayTimestamp($weekMondayTs);
        for ($i = 1; $i <= 7; $i++) {
            $key = DateHelper::formatAsFrom($ts + 86400 * ($i - 1));
            $result[$key] = $value;
        }
        return $result;
    }

    public static function unsetKeys($array, $keys)
    {
        foreach ($keys as $key) {
            if (isset($array[$key])) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * @param $array
     * @return null
     */
    public static function getFirstItem($array)
    {
        $result = null;
        if ($array) {
            $key = array_keys($array)[0];
            $result = $array[$key];
        }
        return $result;
    }

    /**
     * @param $array
     * @param bool $calcCount
     * @return array
     */
    public static function groupAndCountItems($array, $calcCount = true)
    {
        $result = [];

        foreach ($array as $item) {
            $i = count($result) - 1;
            if ($i < 0) {
                $result[] = [
                    $item => 1
                ];
            } else {
                if (isset($result[$i][$item])) {
                    if ($calcCount) {
                        $result[$i][$item]++;
                    }
                } else {
                    $result[] = [
                        $item => 1
                    ];
                }
            }
        }

        return $result;
    }

    public static function groupAndNoCountItems($array)
    {
        $result = [];

        foreach ($array as $key => $item) {
            if (!$key || $array[$key - 1] != $item)
                $result[] = $item;
        }

        /*        if (count($result) == 7 && $result[6]['title'] == 'imodern.retailcrm.ru') {
                    var_dump($array);
                    var_dump($result);
                    die;
                }
        */
        return $result;
    }

    public static function castToInt($array)
    {
        $result = [];

        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $result[$key] = (int)$value;
            }
        } else {
            $result[] = (int)$array;
        }

        return $result;
    }

    public static function removeZero($array)
    {
        foreach ($array as $key => $value) {
            if ($value == 0) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    public static function array2csv($data, $delimiter = ';', $enclosure = '"', $escape_char = "\\")
    {
        $f = fopen('php://memory', 'rb+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escape_char);
        }
        rewind($f);
        return stream_get_contents($f);
    }


    public static function csv2array($file, $delimiter = ';')
    {
        return array_map('str_getcsv', file($file));
    }

    public static function getSubKeys($data)
    {
        $result = [];

        $keys = array_keys($data);

        if ($keys) {
            $key = $keys[0];
            $result = array_keys($data[$key]);
        }

        return $result;
    }

    public static function objectToArray($obj)
    {
        $result = null;
        if (is_object($obj)) {
            $result = get_object_vars($obj);
        }
        return $result;
    }

    public static function mapNotNull($data, $keyIdx, $valueIdx)
    {
        $result = [];
        foreach ($data as $item) {
            if (!is_null($item[$valueIdx])) {
                $result[$item[$keyIdx]] = $item[$valueIdx];
            }
        }
        return $result;
    }

}