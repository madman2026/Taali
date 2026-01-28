<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all();

    public function find(string $field, string $value): ?Model;

    public function findById(int $id);

    public function create(DTO $data);

    public function update(int $id, DTO $data);

    public function delete($content);
}
