<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 31.05.17
 * Time: 21:06
 */

namespace app\components;

use GuzzleHttp\Client;

/**
 * Class HttpClient
 * @package app\components
 */
class HttpClient
{
    /**
     * @var int Last request's HTTP Code
     */
    public static $lastHttpCode;

    /**
     * @var string Last request's HTTP Response
     */
    public static $lastResponse;

    /**
     * Send request
     * @param string $url
     * @param string $method
     * @param array $params
     * @param array $headers
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function send($url, $method = 'GET', array $params = [], array $headers = [])
    {
        if ($method === 'POST') {

            $r = self::getClient()->request('POST', $url, [
                'form_params' => $params,
                'headers' => $headers,
                'http_errors' => false
            ]);
        } else {
            if (strpos($url, '?') !== false) {
                $url .= '&' . http_build_query($params);
            } else {
                $url .= '?' . http_build_query($params);
            }
            $r = self::getClient()->request('GET', $url, [
                'headers' => $headers,
                'http_errors' => false
            ]);
        }
        $response = $r->getBody()->getContents();

        self::$lastHttpCode = $r->getStatusCode();
        self::$lastResponse = $response;

        return self::$lastResponse;
    }

    /**
     * Get last HTTP Code
     * @return int
     */
    public static function getLastHttoCode()
    {
        return self::$lastHttpCode;
    }

    /**
     * Get last HTTP Response
     * @return string
     */
    public static function getLastResponse()
    {
        return self::$lastResponse;
    }

    /**
     * @return Client
     */
    private static function getClient()
    {
        return new Client();
    }
}
