<?php


namespace App\InputData\Strategies;


use App\InputData\ReaderSettings;

class Tsv extends Csv
{
    protected const SEPARATOR = "\t";

    public function prepareDataForRead(ReaderSettings $settings): void
    {
        if ($settings->tsv_skip_header) {
            $header_row_to_skip = $this->getRow();
        }
    }
}