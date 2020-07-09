<?php


namespace App\Models;


use League\Csv\Reader;
use App\Libs\GeoNames;
use App\Libs\IPStackAPI;
use League\Csv\Exception;

class Statistic {

    private $dir = 'storage/';
    private $databaseGeoNames = 'storage/countryinfo.csv';
    public $filename;

    /**
     * upload statistic file
     *
     * @param $filename
     * @return array
     */
    public function uploadFile($filename)
    {
        return uploadFile($this->dir, $filename);
    }

    /**
     * parse records from statistic
     *
     * @param $filename
     * @return array|bool
     * @throws Exception
     */
    public function parseRecords($filename)
    {
        if (file_exists($this->dir . $filename)) {
            $csv = Reader::createFromPath($this->dir . $filename);

            $records = $csv->getRecords();

            $geoPhoneCode = GeoNames::phoneCodes($this->databaseGeoNames);

            $statisticResult = [];
            foreach ($records as $key => $record) {
                $customerId = $record[0];
                $ip = $record[4];
                $duration = $record[2];

                $phonePrefix = substr($record[3], 0, 3);

                if (isset($geoPhoneCode[$phonePrefix])) {
                    $continentGeoCode = $geoPhoneCode[$phonePrefix];
                } else {
                    continue;
                }

                $ipStack = new IPStackAPI();
                $ipStackResult = $ipStack->call($ip);

                $continentIpCode = $ipStackResult->continent_code;

                if (!array_key_exists($customerId, $statisticResult)) {
                    $statisticResult[$customerId] = [
                        'continents' => [],
                        'number_of_calls' => 0,
                        'total_duration' => 0,
                    ];
                }

                $statisticResult[$customerId]['number_of_calls'] += 1;
                $statisticResult[$customerId]['total_duration'] += $duration;

                if ($continentIpCode == $continentGeoCode) {
                    if (!array_key_exists($continentGeoCode, $statisticResult[$customerId]['continents'])) {
                        $statisticResult[$customerId]['continents'][$continentGeoCode] = [
                            'continents_count' => 0,
                            'total_continents_count' => 0,
                        ];
                    }
                    $statisticResult[$customerId]['continents'][$continentGeoCode]['continents_count'] += 1;
                    $statisticResult[$customerId]['continents'][$continentGeoCode]['total_continents_count'] += $duration;
                }
            }

            return $statisticResult;
        }

        return false;
    }
}
