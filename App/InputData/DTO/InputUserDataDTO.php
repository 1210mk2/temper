<?php


namespace App\InputData\DTO;


use App\System\DTO\BasicDTO;

class InputUserDataDTO extends BasicDTO
{
    public int       $user_id;
    public \DateTime $created_at;
    public int       $onboarding_perentage;
    public int       $count_applications;
    public int       $count_accepted_applications;

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
            'user_id'                       => $arr[0],
            'created_at'                    => $arr[1],
            'onboarding_perentage'          => $arr[2],
            'count_applications'            => $arr[3],
            'count_accepted_applications'   => $arr[4],
        ];
        return self::fromObject($obj);
    }

    public static function fromObject(object $obj): BasicDTO
    {
        $obj->user_id                     = (int)$obj->user_id;
        $obj->created_at                  = \DateTime::createFromFormat("Y-m-d", $obj->created_at);
        $obj->onboarding_perentage        = (int)$obj->onboarding_perentage;
        $obj->count_applications          = (int)$obj->count_applications;
        $obj->count_accepted_applications = (int)$obj->count_accepted_applications;

        return parent::fromObject($obj);
    }

}