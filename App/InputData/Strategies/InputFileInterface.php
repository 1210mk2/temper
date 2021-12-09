<?php


namespace App\InputData\Strategies;


use App\InputData\ReaderSettings;

interface InputFileInterface
{
    public function open(): void;

    public function prepareDataForRead(ReaderSettings $settings): void;

    public function getData(): array;

    public function getRowIterator(): \Iterator;
}