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

        $statistic = new Statistic();

        $fileStatistic = $statistic->uploadFile('statistic_file');

        if (!$fileStatistic['success']) {
            return view('pages/statistic', ['error' => $fileStatistic['error']]);
        }

        $statistic = $statistic->parseRecords($fileStatistic['filename']);

        return view('pages/statistic', compact('statistic'));
    }
}
