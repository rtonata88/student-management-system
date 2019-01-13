<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class HwplActivities extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    $chart = new Highcharts;

    $chart->labels(['One', 'Two', 'Three']);
}
