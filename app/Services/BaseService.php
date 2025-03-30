<?php

namespace App\Services;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\DTOs\BaseDTO;
use App\Services\Interfaces\BaseServiceInterface;

abstract class BaseService implements BaseServiceInterface
{
    public function __construct(protected BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(BaseDTO $dto)
    {
        return $this->repository->create($dto->toArray());
    }

    public function update(int $id, BaseDTO $dto)
    {
        return $this->repository->update($id, $dto->toArray());
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    public function paginate(int $perPage = 15)
    {
        return $this->repository->paginate($perPage);
    }
} 