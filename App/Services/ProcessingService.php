<?php


namespace App\Services;


use App\InputData\Strategies\InputFileInterface;
use App\Repo\UserDataRepo;
use App\Repo\UserRepo;

class ProcessingService
{
    private $_user_repo;
    private $_user_data_repo;

    public function __construct(UserRepo $_user_repo, UserDataRepo $_user_data_repo)
    {
        $this->_user_repo      = $_user_repo;
        $this->_user_data_repo = $_user_data_repo;
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
                $input_user_data = \App\InputData\DTO\InputUserDataDTO::fromArray($row);
                $this->_user_data_repo->save($input_user_data);
            }
        }
    }

    public function calculate()
    {
        $ud_data = $this->_user_data_repo->getAll();
        $u_data = $this->_user_repo->getAll();
    }
}