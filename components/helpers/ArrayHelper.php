<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.06.17
 * Time: 15:55
 */

namespace app\components\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{

    /**
     * @param array $array
     * @param string $keyField
     * @param mixed $valueField
     * @return array
     */
    public static function dropDownDownListFormat(array $array, $keyField, $valueField)
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

    /**
     * @param array $array
     * @param string $title
     * @param mixed $nullIndex
     * @return array
     */
    public static function addDropDownEmptyValue(array $array, $title = 'Неважно', $nullIndex = null)
    {
        $result = [];
        $result[$nullIndex] = $title;
        foreach ($array as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    /**
     * @param array $rows
     * @param mixed $key
     * @return float|mixed|null
     */
    public static function getMaxValue(array $rows, $key)
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

    /**
     * @param array $rows
     * @return mixed
     */
    public static function getMaxSubValue(array $rows)
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

    /**
     * @param array $array
     * @param mixed $field
     * @param mixed $value
     * @return mixed
     */
    public static function getItemByField(array $array, $field, $value)
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

    /**
     * @param array $rows
     * @param mixed $key
     * @return int
     */
    public static function getSumValue(array $rows, $key)
    {
        $result = 0;
        foreach ($rows as $row) {
            $result += $row[$key];
        }
        return $result;
    }

    /**
     * @param array $rows
     * @param mixed $key1
     * @param mixed $key2
     * @return mixed
     */
    public static function getMaxValue2(array $rows, $key1, $key2)
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

    public static function getDuplicateValue($array, $key)
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

    /**
     * @param array $array
     * @param int $chunkSize
     * @return array
     */
    public static function splitByChunks(array $array, $chunkSize = 10)
    {
        $result = [];
        for ($i = 0, $iMax = count($array); $i < $iMax; $i += $chunkSize) {
            $result[] = array_slice($array, $i, $chunkSize);
        }
        return $result;
    }

    /**
     * Дозаполняет массив чтобы везде одинаковое количество индексов
     * @param $array
     * @param int $defaultValue
     * @return mixed
     */
    public static function upToFill(array $array, $defaultValue = 0)
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

    /**
     * @param int $from
     * @param int $to
     * @return array
     */
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

    /**
     * @param $array
     * @param int $from
     * @param int $to
     * @param mixed $value
     * @return array
     */
    public static function fillByTimestamp(array $array, $from, $to, $value = 0)
    {
        $result = $array;

        $from = (int)$from;
        $to = (int)$to;

        for ($ts = $from; $ts <= $to; $ts += 86400) {
            $result[DateHelper::formatAsFrom($ts)] = $value;
        }

        return $result;
    }

    /**
     * @param $array
     * @param int $from
     * @param int $to
     * @param mixed $value
     * @return array
     */
    public static function fillByWeekTimestamp(array $array, $from, $to, $value = 0)
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

    /**
     * @param $array
     * @param int $from
     * @param int $to
     * @param mixed $value
     * @return array
     */
    public static function fillByMonthTimestamp(array $array, $from, $to, $value = 0)
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

    /**
     * @param $array
     * @param int $from
     * @param int $to
     * @param mixed $value
     * @return array
     */
    public static function fillByMondayTimestamp(array $array, $from, $to, $value = 0)
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

    /**
     * @param $array
     * @param int $from
     * @param int $to
     * @param mixed $value
     * @return array
     */
    public static function fillByHourTimestamp(array $array, $from, $to, $value = 0)
    {
        $result = $array;

        $from = (int)$from;
        $to = (int)$to;

        for ($ts = $from; $ts <= $to; $ts += 3600) {
            $result[strtotime(date('Y-m-d H:00', $ts))] = $value;
        }

        return $result;
    }

    /**
     * @param array $array
     * @param int $monthTs
     * @param mixed $value
     * @return array
     */
    public static function fillByMonthWeeksMondayTimestamp(array $array, $monthTs, $value = 0)
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

    /**
     * @param array $array
     * @param int $weekMondayTs
     * @param mixed $value
     * @return array
     */
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

    /**
     * @param array $array
     * @param array $keys
     * @return array
     */
    public static function unsetKeys(array $array, array $keys)
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

    /**
     * @param array $array
     * @return array
     */
    public static function groupAndNoCountItems(array $array)
    {
        $result = [];

        foreach ($array as $key => $item) {
            if (!$key || $array[$key - 1] != $item) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @param array $array
     * @return array
     */
    public static function castToInt(array $array)
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

    /**
     * @param array $array
     * @return array
     */
    public static function removeZero(array $array)
    {
        foreach ($array as $key => $value) {
            if ($value == 0) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    /**
     * @param array $data
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeChar
     * @return false|string
     */
    public static function array2csv(array $data, $delimiter = ';', $enclosure = '"', $escapeChar = "\\")
    {
        $f = fopen('php://memory', 'rb+');
        foreach ($data as $item) {
            fputcsv($f, $item, $delimiter, $enclosure, $escapeChar);
        }
        rewind($f);
        return stream_get_contents($f);
    }

    /**
     * @param string $file
     * @param string $delimiter
     * @return array
     */
    public static function csv2array($file, $delimiter = ';')
    {
        return array_map('str_getcsv', file($file));
    }

    /**
     * @param array $data
     * @return array
     */
    public static function getSubKeys(array $data)
    {
        $result = [];

        $keys = array_keys($data);

        if ($keys) {
            $key = $keys[0];
            $result = array_keys($data[$key]);
        }

        return $result;
    }

    /**
     * @param mixed $obj
     * @return array|null
     */
    public static function objectToArray($obj)
    {
        $result = null;
        if (is_object($obj)) {
            $result = get_object_vars($obj);
        }
        return $result;
    }

    /**
     * @param array $data
     * @param mixed $keyIdx
     * @param mixed $valueIdx
     * @return array
     */
    public static function mapNotNull(array $data, $keyIdx, $valueIdx)
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