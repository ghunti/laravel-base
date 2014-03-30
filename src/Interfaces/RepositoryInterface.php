<?php

namespace Ghunti\LaravelBase\Interfaces;

interface RepositoryInterface
{
    /**
    * Create a new instance of the repository, passing its underlying model
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    */
    public function __construct(ModelInterface $model);

    /**
    * Get all of the models from the database.
    *
    * @param array $columns
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function all($columns = array('*'));

    /**
    * Find a model by its primary key.
    *
    * @param mixed $id
    * @param array $columns
    * @return \Illuminate\Database\Eloquent\Model|Collection
    */
    public function find($id, array $columns = array('*'));

    /**
    * Find a model by its primary key or throw an exception.
    *
    * @param mixed $id
    * @param array $columns
    * @return \Illuminate\Database\Eloquent\Model|Collection
    *
    * @throws ModelNotFoundException
    */
    public function findOrFail($id = null, array $columns = array('*'));

    /**
    * Save a new model and return the instance.
    *
    * @param array $attributes
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function create(array $attributes);

    /**
    * Save the model to the database.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @param array $options
    * @return bool
    */
    public function save(ModelInterface $model, array $options = array());

    /**
    * Get the first record matching the attributes or create it.
    *
    * @param array $attributes
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function firstOrCreate(array $attributes);

    /**
    * Get the first record matching the attributes or instantiate it.
    *
    * @param array $attributes
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function firstOrNew(array $attributes);

    /**
    * Save the model and all of its relationships.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @return bool
    */
    public function push(ModelInterface $model);

    /**
    * Delete the model from the database.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @return bool|null
    */
    public function delete(ModelInterface $model);

    /**
    * Destroy the models for the given IDs.
    *
    * @param array|int $ids
    * @return int
    */
    public function destroy($ids);

    /**
    * Update the model's update timestamp.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @return bool
    */
    public function touch(ModelInterface $model);
}
