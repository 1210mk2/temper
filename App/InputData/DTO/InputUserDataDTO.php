<?php


namespace App\InputData\DTO;


use App\System\DTO\BasicDTO;

class InputUserDataDTO extends BasicDTO
{
    public int       $user_id;
    public \DateTime $created_at;
    public int $onboarding_perentage;
    public int $count_applications;
    public int $count_accepted_applications;

    public function __construct($obj)
    {
        $this->user_id                     = $obj->user_id;
        $this->created_at                  = $obj->created_at;
        $this->onboarding_perentage        = $obj->onboarding_perentage;
        $this->count_applications          = $obj->count_applications;
        $this->count_accepted_applications = $obj->count_accepted_applications;
    }

    public static function fromArray(array $arr): BasicDTO
    {
        $obj = (object)[
            'user_id'                       => (int)$arr[0],
            'created_at'                    => \DateTime::createFromFormat("Y-m-d", $arr[1]),
            'onboarding_perentage'          => (int)$arr[2],
            'count_applications'            => (int)$arr[3],
            'count_accepted_applications'   => (int)$arr[4],
        ];
        return self::fromObject($obj);
    }

}