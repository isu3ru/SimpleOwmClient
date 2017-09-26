<?php
/*
Copyright (c) 2017 - Isuru Ranawaka <isu3ru@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/


require 'vendor/autoload.php';

namespace Isu3ru\Apis;

/**
 * SimpleOWMClient
 * Simple Open Weather Map Api Client for free weather map api from openweathermap.org
 */
class SimpleOwmClient {

    /**
     * Your OWM API key
     */
    const API_KEY = '';

    /**
     * URL to owmapi here. (If changed) - No trailing slash
     */
    const URL = 'http://api.openweathermap.org/data/2.5/weather';

    /**
     * City name
     */
    const CITY_NAME = '';

    /**
     * Unit Type
     * Metric for Celcius and Imperaial for Farenheit
     */
    const UNIT_TYPE = 'metric';

    /**
     * Result cache control
     * - not implemented yet
     */
    var $isCached = FALSE;

    /**
     * Create new instance
     */
    public function __construct($isCached = FALSE) {
        if ($isCached) {
            $this->isCached = TRUE;
        }
    }

    /**
     * Utility function to execute a HTTP GET request
     */
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

    /**
     * Request data from OWM Api
     */
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

