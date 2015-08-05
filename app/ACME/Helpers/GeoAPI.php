<?php namespace App\ACME\Helpers;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;

class GeoAPI{

    public static $url="http://api.sypexgeo.net/json/";

    public static function  getByIP($ip)
    {
        $curl =  new GuzzleHttp\Client();
        try {
            $res = $curl->get(static::$url.$ip);
            return json_decode($res->getBody()->getContents());
        }catch (RequestException $e)
        {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            }
        }
    }
}