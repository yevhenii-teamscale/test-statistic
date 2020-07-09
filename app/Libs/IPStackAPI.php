<?php


namespace App\Libs;


class IPStackAPI {

    private $apiKey = 'd9f000dbc0237078dfb39bf8033d244c';
    public $apiUrl = 'http://api.ipstack.com/';

    /**
     * call the IPstack API
     * @param $ip
     * @return mixed
     */
    public function call($ip)
    {
        $curlCall = curlCall($this->apiUrl . $ip . '?access_key=' . $this->apiKey);
        return json_decode($curlCall);
    }
}
