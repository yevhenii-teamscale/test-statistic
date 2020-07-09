<?php

namespace App\Controllers;

use App\Models\Statistic;
use League\Csv\Exception;

class StatisticController {

    /**
     * show all statistic page
     *
     * @throws Exception
     */
    public function index()
    {
        if (empty($_FILES)) {
            return view('pages/statistic', ['error' => 'You should upload file']);
        }

        $fileStatistic = uploadFile(storageDir(), 'statistic_file');

        if (!$fileStatistic['success']) {
            return view('pages/statistic', ['error' => $fileStatistic['error']]);
        }

        $statistic = new Statistic();

        $statisticData = [];
        if ($statistic->readFile($fileStatistic['filename'])) {
            $statisticData = $statistic->parseRecords();
        }

        return view('pages/statistic', ['statistic' => $statisticData]);
    }
}
