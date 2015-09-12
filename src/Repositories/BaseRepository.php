<?php

namespace Ghunti\LaravelBase\Repositories;

use Ghunti\LaravelBase\Interfaces\RepositoryInterface;
use Ghunti\LaravelBase\Interfaces\ModelInterface;
use Ghunti\LaravelBase\Eloquent\BaseBuilder;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model = null;

    /**
    * Create a new instance of the repository, passing its underlying model
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    */
    public function __construct(ModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * Proxy the call to the underlying model since all the work
     * is done by it.
     *
     * @param  string $method    The method to invoke
     * @param  array $arguments The arguments to pass to the method
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        //Does the model know how to handle this?
        if (method_exists($this->model, $method)) {
            return call_user_func_array(
                array(
                    $this->model,
                    $method
                ),
                $arguments
            );
        }

        //Mimic the behavior of Eloquent\Model::__call but also inject the
        //repository into the query builder
        $queryBuilder = $this->model->newQuery();
        $queryBuilder->setRepository($this);
        return call_user_func_array([$queryBuilder, $method], $arguments);
    }

    /**
    * Save the model to the database.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @param array $options
    * @return bool
    */
    public function save(ModelInterface $model, array $options = array())
    {
        return $model->save($options);
    }

    /**
    * Save the model and all of its relationships.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @return bool
    */
    public function push(ModelInterface $model)
    {
        return $model->push();
    }

    /**
    * Delete the model from the database.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @return bool|null
    */
    public function delete(ModelInterface $model)
    {
        return $model->delete();
    }

    /**
    * Update the model's update timestamp.
    *
    * @param Ghunti\LaravelBase\Interfaces\ModelInterface $model
    * @return bool
    */
    public function touch(ModelInterface $model)
    {
        return $model->touch();
    }
}
