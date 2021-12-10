<?php


namespace App\InputData\Strategies;


use App\InputData\DTO\InputUserDataDTO;
use App\InputData\ReaderSettings;
use App\System\DTO\BasicDTO;

class Csv extends InputFileCommon
{
    protected const SEPARATOR = ",";

    public function getData(): array
    {
        $data = [];
        while ($row = $this->getRowIterator()) {
            $data[] = $row;
        }

        return $data;
    }

    public function getRowIterator(): \Iterator
    {
        while ($row = $this->getRow()) {
            yield $row;
        }
    }

    public function getRow(): ?array
    {
        if (!feof($this->handle)) {
            return fgetcsv($this->handle, 0, static::SEPARATOR);
        }
        return null;
    }

    public function prepareDataForRead(ReaderSettings $settings): void
    {
        if ($settings->csv_skip_header) {
            $header_row_to_skip = $this->getRow();
        }
    }

    public function getDTObyRow($row): BasicDTO
    {
        return InputUserDataDTO::fromArray($row);
    }
}