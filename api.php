<?php

function distance_api($pincode)
{
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address='$pincode'&key=AIzaSyC3nSH3nD_lgHPgXS6Ci5DYEpONbpK1j70";
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $json = curl_exec($curl);

    $decode = json_decode($json, true);
    $results1[] = $decode['results'][0];
    $results2[] = $results1[0]['geometry'];
    $results3[] = $results2[0]['location'];


    return $results3[0];
}

function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=pl-PL&key=AIzaSyC3nSH3nD_lgHPgXS6Ci5DYEpONbpK1j70";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return array('distance' => $dist, 'time' => $time);
}

$source_array = distance_api('248001');
$destination_array = distance_api('248171');
$lat1 = $source_array["lat"];
$lon1 = $source_array["lng"];
$lat2 = $destination_array["lat"];
$lon2 = $destination_array["lng"];
print_r(GetDrivingDistance($lat1, $lat2, $lon1, $lon2));
