<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Modules\Content\Models\Content;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->model::paginate(10);
    }

    public function findById(int $id): ?Model
    {
        return $this->model::query()->findOrFail($id);
    }

    public function find(string $field, string $value): ?Model
    {
        return $this->model::query()->where($field, $value)->first();
    }

    public function create(DTO $data): Model
    {
        return $this->model::query()->create($data->toArray());
    }

    public function update(int $id, DTO $data): bool
    {
        return $this->model::query()->findOrFail($id)->update($data->toArray());
    }

    /**
     * @param  Content  $content
     */
    public function delete($content): bool
    {
        return $content->delete();
    }
}
