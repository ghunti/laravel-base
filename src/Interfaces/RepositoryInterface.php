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
    * Save the model to the database.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @param array $options
    * @return bool
    */
    public function save(ModelInterface $model, array $options = array());

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
    * Update the model's update timestamp.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @return bool
    */
    public function touch(ModelInterface $model);
}
