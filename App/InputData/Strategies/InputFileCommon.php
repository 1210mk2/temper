<?php


namespace App\InputData\Strategies;


abstract class InputFileCommon implements InputFileInterface
{
    protected string $path;
    protected $handle;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function open(): void
    {
        $this->handle = fopen($this->path, 'r');
    }

    abstract public function getData(): array;

    abstract public function getRowIterator(): \Iterator;
}