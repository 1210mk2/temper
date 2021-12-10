<?php


namespace App\InputData\Strategies;


use App\InputData\ReaderSettings;
use App\System\DTO\BasicDTO;

interface InputFileInterface
{
    public function open(): void;

    public function prepareDataForRead(ReaderSettings $settings): void;

    public function getData(): array;

    public function getRowIterator(): \Iterator;

    public function getDTObyRow($row): BasicDTO;

}