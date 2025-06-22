<?php

namespace NaingMinKhant\MyRepo;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @template T
 */
class NmkRepository implements NmkRepositoryInterface
{
    /**
     * @param T $model
     * @throws Exception
     */
    public function __construct(protected $model = null)
    {
        if (is_null($this->model)) {
            throw new Exception("Model doesn't provided!");
        }
        $this->model = new $this->model;
        if (!($this->model instanceof Model)) {
            throw new Exception("Class " . get_class($this->model) . " must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getById(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function create(array $data): Model
    {
        try {
            $createdModel = $this->model->create($data);
            Log::info("Model created: " . $createdModel);
            return $createdModel;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model
     * @throws Exception
     */
    public function update(int $id, array $data): Model
    {
        try {
            $user = $this->model->find($id);
            $user->update($data);
            Log::info("Model updated: " . $user);
            return $user;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        try {
            $user = $this->model->find($id);
            return $user->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
