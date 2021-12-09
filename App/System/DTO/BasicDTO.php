<?php

namespace App\System\DTO;

abstract class BasicDTO
{

    abstract public function __construct($obj);

    public static function fromObject(object $obj): self
    {
        return new static($obj);
    }

    public static function fromArray(array $arr): self
    {
        return static::fromObject((object) $arr);
    }

    public static function fromObjectExcluding(object $obj, array $exclude_properties): self
    {
        foreach ($exclude_properties as $prop) {
            $obj->$prop = null;
        }

        $_instance = self::fromObject($obj);

        foreach ($exclude_properties as $prop) {
            unset($_instance->{$prop});
        }

        return $_instance;
    }

    public static function getFields(): array
    {
        return array_keys(get_class_vars(get_called_class()));
    }

}