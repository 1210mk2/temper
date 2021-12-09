<?php


namespace App\Repo;


use App\Repo\DTO\RepoUserDTO;

class UserRepo
{
    private array $keyed_storage = [];

    public function save(RepoUserDTO $person): void
    {
        $key = $person->key;
        $this->keyed_storage[$key] = $person;
    }

    public function getAll(): array
    {
        return $this->keyed_storage;
    }

    public function getByKey(int $key): ?RepoUserDTO
    {
        return $this->keyed_storage[$key] ?? null;
    }
}