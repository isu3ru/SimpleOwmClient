<?php
require 'vendor/autoload.php';

namespace Isu3ru\Apis;

class SimpleOwmClient {
    const API_KEY = '';

    //no trailing slash
    const URL = 'http://api.openweathermap.org/data/2.5/weather';
    const CITY_NAME = '';
    const UNIT_TYPE = 'metric';
    var $isCached = FALSE;

    public function __construct($isCached = FALSE) {
        if ($isCached) {
            $this->isCached = TRUE;
        }
    }

    private function getRequest($url, $query_data) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => sprintf('%s/?%s',
                $url, http_build_query($query_data) 
            ),
            CURLOPT_USERAGENT => 'Simple Open Weather Map Client'
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

    public function request() {
        $query_data = [
            'q'=>self::CITY_NAME,
            'units'=>self::UNIT_TYPE,
            'appid'=>self::API_KEY
        ];
        $json = $this->getRequest(self::URL, $query_data);
        $data = json_decode($json);
        return $data;
    }
}

