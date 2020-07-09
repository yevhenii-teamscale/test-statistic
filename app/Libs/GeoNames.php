<?php


namespace App\Libs;


use League\Csv\Reader;
use League\Csv\Exception;

class GeoNames {


    /**
     * return array phone code associated with continent
     * @param $database
     * @return array|bool
     * @throws Exception
     */
    public static function phoneCodes($database)
    {
        if (file_exists($database)) {
            $csv = Reader::createFromPath($database);

            $csv->setEscape('#');
            $csv->setDelimiter("\t");
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();

            $result = [];
            foreach ($records as $offset => $record) {
                $result[$record['Phone']] = $record['Continent'];
            }

            return $result;
        }

        return false;
    }
}
