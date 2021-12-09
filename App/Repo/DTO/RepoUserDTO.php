<?php


namespace App\Repo\DTO;


use App\InputData\DTO\InputUserDataDTO;
use App\System\DTO\BasicDTO;

class RepoUserDTO extends BasicDTO
{
    public int          $key;

    public function __construct($obj)
    {
        $this->key    = $obj->key;
    }

    public static function fromObject(InputUserDataDTO $obj): self
    {
        return parent::fromObject((object) [
            'key'   => $obj->user_id,
        ]);
    }
}