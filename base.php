<?php
/**
 * Created by PhpStorm.
 * User: Maydin
 * Date: 17.6.2016
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

define("BASE_DOMAIN", "http://api.football-data.org/v1/soccerseasons/424/");
define("API_KEY", "YOUR-API-KEY");


$group_letters = array('A', 'B', 'C', 'D', 'E', 'F');
$time_params = array("FINISHED" => "Tamamlandı", "TIMED" => "Oynanmadı");

function getFootBallData($api_postfix = null, $full_url=null)
{
    if (!$full_url)
        $uri = BASE_DOMAIN . $api_postfix;
    else
        $uri = $full_url;

    $reqPrefs['http']['method'] = 'GET';
    $reqPrefs['http']['header'] = 'X-Auth-Token: ' . API_KEY;
    $stream_context = stream_context_create($reqPrefs);
    $response = file_get_contents($uri, false, $stream_context);
    $fixtures = json_decode($response);
    return $fixtures;
}

function convertToSef($string)
{
    $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
    $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
    $string = strtolower(str_replace($find, $replace, $string));
    $string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
    $string = trim(preg_replace('/\s+/', ' ', $string));
    $string = str_replace(' ', '-', $string);
    return $string;
}

function getTeamName($url)
{
    return getFootBallData(null, $url);
}

