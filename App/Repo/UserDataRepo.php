<?php


namespace App\Repo;


use App\InputData\DTO\InputUserDataDTO;
use App\Repo\DTO\RepoUserDTO;
use App\Repo\DTO\RepoUserDataDTO;

class UserDataRepo
{
    private array $ai_keyed_storage   = [];
    private array $user_keyed_index = [];

    private UserRepo $_user_repo;

    public function __construct(UserRepo $_user_repo)
    {
        $this->_user_repo = $_user_repo;
    }

    public function save(InputUserDataDTO $input_user_data): void
    {
        $user_dto = RepoUserDTO::fromObject($input_user_data);
        $this->_user_repo->save($user_dto);

        $repo_user_data_dto = RepoUserDataDTO::fromObject($input_user_data);

        $primary_key = $this->saveWithAIKey($repo_user_data_dto);
        $this->createUserKeyIndex($repo_user_data_dto, $primary_key);
    }

    private function saveWithAIKey(RepoUserDataDTO $repo_user_data_dto): int
    {
        static $inc_key = 0;

        $this->ai_keyed_storage[$inc_key] = $repo_user_data_dto;

        $current_key = $inc_key;
        $inc_key++;

        return $current_key;
    }

    public function getAll(): array
    {
        return $this->ai_keyed_storage;
    }

    public function getByPrimaryKey(int $primary_key): ?RepoUserDataDTO
    {
        return $this->ai_keyed_storage[$primary_key] ?? null;
    }

    public function getByPrimaryKeys(array $primary_keys): array
    {
        $result = [];
        foreach ($primary_keys as $primary_key) {
            $item = $this->getByPrimaryKey($primary_key);
            if (!$item) {
                continue;
            }
            $result[] = $item;
        }
        return $result;
    }

    public function getByPrimaryKeysGenerator(array $primary_keys): \Iterator
    {
        foreach ($primary_keys as $primary_key) {
            $item = $this->getByPrimaryKey($primary_key);
            if (!$item) {
                continue;
            }
            yield $item;
        }
    }

    private function createUserKeyIndex(RepoUserDataDTO $repo_user_data_dto, int $primary_key): void
    {
        $this->user_keyed_index[$repo_user_data_dto->i_user_id][] = $primary_key;
    }

    public function getAllByUser(int $i_user): ?array
    {
        $primary_keys = $this->user_keyed_index[$i_user] ?? [];
        return $this->getByPrimaryKeys($primary_keys);

    }

    public function getAllByUserGenerator(int $i_user): \Iterator
    {
        $primary_keys = $this->user_keyed_index[$i_user] ?? [];
        return $this->getByPrimaryKeysGenerator($primary_keys);

    }



}