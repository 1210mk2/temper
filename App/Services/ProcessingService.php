<?php


namespace App\Services;


use App\InputData\Strategies\InputFileInterface;

class ProcessingService
{
    public function __construct()
    {
    }

    /**
     * @param array<string, InputFileInterface> $collection
     */
    public function process(array $collection)
    {
        foreach ($collection as $strategy) {

            $strategy->open();
            $strategy->prepareDataForRead(new \App\InputData\ReaderSettings());
            $data = $strategy->getRowIterator();
            foreach ($data as $row) {
                $item = \App\InputData\DTO\UserDTO::fromArray($row);
            }
        }
    }

}