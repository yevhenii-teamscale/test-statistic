<?php


namespace App\Models;


use League\Csv\Reader;
use App\Libs\GeoNames;
use App\Libs\IPStackAPI;
use League\Csv\Exception;

class Statistic {

    private $databaseGeoNames = 'storage/countryinfo.csv';
    private $records;

    /**
     * read statistic file
     *
     * @param $filename
     * @return bool
     */
    public function readFile($filename)
    {
        if (file_exists(storageDir() . $filename)) {
            $csv = Reader::createFromPath(storageDir() . $filename);

            $this->records = $csv->getRecords();

            return true;
        }

        return false;
    }

    /**
     * parse records from statistic
     *
     * @return array|bool
     * @throws Exception
     */
    public function parseRecords()
    {
        $geoPhoneCode = GeoNames::phoneCodes($this->databaseGeoNames);

        $statisticResult = [];
        foreach ($this->records as $key => $record) {
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
}
