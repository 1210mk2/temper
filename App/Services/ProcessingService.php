<?php


namespace App\Services;


use App\InputData\Strategies\InputFileInterface;
use App\Repo\UserDataRepo;
use App\Repo\UserRepo;

class ProcessingService
{
    private UserRepo $_user_repo;
    private UserDataRepo $_user_data_repo;

    private array $steps;

    public function __construct(UserRepo $_user_repo, UserDataRepo $_user_data_repo)
    {
        $this->_user_repo      = $_user_repo;
        $this->_user_data_repo = $_user_data_repo;
    }

    public function getSteps(): array
    {
        return $this->steps;
    }

    public function setSteps(array $steps): void
    {
        $this->steps = $steps;
    }

    private function calculateStepsToIncByPerc($percent)
    {
        if ($percent < 0) {
            return 0;
        }
        $steps = $this->getSteps();
        $l = count($steps);
        for ($n = 0; $n < $l; $n++) {
            if ($percent < $steps[$n]->perc) {
                return $n;
            }
        }
        return $l;
    }
    private function getStepsCountToIncByPerc($percent)
    {
        static $steps_to_inc_by_perc;
        $steps_to_inc_by_perc[$percent] = $steps_to_inc_by_perc[$percent] ?? $this->calculateStepsToIncByPerc($percent);
        return $steps_to_inc_by_perc[$percent];
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
                $input_user_data = $strategy->getDTObyRow($row);
                $this->_user_data_repo->save($input_user_data);
            }
        }

    }

    private function getZeroCountBySteps()
    {
        return array_fill(0, count($this->getSteps()), 0);
    }

    public function calculate(int $ts_week_diff, array $steps): array
    {
        $this->setSteps($steps);

        $result = [];

        $user_data_iterator = $this->_user_data_repo->getAllGenerator();
        foreach ($user_data_iterator as $item) {
            $cohort_number = intdiv($item->i_timestamp, $ts_week_diff);

            $result[$cohort_number] = $result[$cohort_number] ?? (object)[
                    "step_count"    => $this->getZeroCountBySteps(),
//                    "cohort_count"  => 0,
                ];

            $step_to_inc_count = $this->getStepsCountToIncByPerc($item->i_percent);
            for ($i = 0; $i < $step_to_inc_count; $i++) {
                $result[$cohort_number]->step_count[$i]++;
            }

//            $result[$cohort_number]->cohort_count++; //will use first step
        }

        return $result;
    }
}