<?php
/**
 * Created by PhpStorm.
 * User: isuru
 * Date: 10/27/17
 * Time: 1:48 AM
 */

namespace Isuru\ApiClient;

/**
 * Simple Open Weather Map Api Client for free weather map api from openweathermap.org
 */
class SimpleOwmClient {

    const UNIT_TYPE_METRIC = 'metric';
    const UNIT_TYPE_IMPERIAL = 'imperial';

    /**
     * URL to owmapi here. (If changed) - No trailing slash
     */
    var $url = 'http://api.openweathermap.org/data/2.5/weather';

    /**
     *
     * @var type string
     */
    var $userAgentString = 'ISU3RU_SIMPLE_OWM_CLIENT';

    /**
     * Your OWM API key
     */
    var $apiKey = '';

    /**
     * City name
     */
    var $cityName = '';

    /**
     * Result cache control
     * - not implemented yet
     */
    var $isCached = FALSE;

    public function __construct($cityName, $aiKey) {
        $this->apiKey = $aiKey;
        $this->cityName = $cityName;
    }

    /**
     * Utility function to execute a HTTP GET request
     */
    private function getRequest($url, $query_data) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => sprintf('%s/?%s', $url, http_build_query($query_data)
            ),
            CURLOPT_USERAGENT => self::USERAGENT_STRING
        ));
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

    /**
     * Request data from OWM Api
     */
    protected function request() {
        if (trim($this->cityName) === '' || trim($this->apiKey) === '') {
            return json_decode(FALSE);
        }

        $json = $this->getRequest($this->url, [
            'q' => $this->cityName,
            'units' => self::UNIT_TYPE_METRIC, //use metric units: c, not f
            'appid' => $this->apiKey
        ]);
        return json_decode($json);
    }

}