<?php


namespace App\InputData\Strategies;


use App\InputData\DTO\InputJsonUserDataDTO;
use App\InputData\DTO\InputUserDataDTO;
use App\InputData\ReaderSettings;
use App\System\DTO\BasicDTO;

class Json extends InputFileCommon
{
    protected array $json_contents;
    protected \ArrayObject $array_object;

    public function getData(): array
    {
        return $this->json_contents;
    }

    public function getRowIterator(): \Iterator
    {
        return $this->array_object->getIterator();
    }

    public function prepareDataForRead(ReaderSettings $settings): void
    {
        $contents = fread($this->handle, filesize($this->path));
        fclose($this->handle);
        $this->json_contents = json_decode($contents);
        $this->array_object = new \ArrayObject( $this->json_contents );
    }

    public function getDTObyRow($row): BasicDTO
    {
        return InputUserDataDTO::fromObject($row);
    }

}