<?php


namespace App\Repo\DTO;


use App\System\DTO\BasicDTO;
use App\InputData\DTO\InputUserDataDTO;

class RepoUserDataDTO extends BasicDTO
{
//    public int          $key;
    public int          $i_timestamp;
    public int          $i_user_id;

    public function __construct($obj)
    {
//        $this->key         = $obj->key;
        $this->i_timestamp = $obj->i_timestamp;
        $this->i_user_id   = $obj->i_person;
        $this->i_percent   = $obj->i_percent;
    }

    public static function fromObject(InputUserDataDTO $obj): self
    {
        return parent::fromObject((object) [
//            'key'         => $inc_key,
            'i_timestamp' => $obj->created_at->getTimestamp(),
            'i_person'    => $obj->user_id,
            'i_percent'   => $obj->onboarding_perentage,
        ]);
    }

}